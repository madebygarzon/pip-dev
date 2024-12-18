<?php

add_action('admin_menu', 'add_extended_report_page');

function add_extended_report_page()
{
    add_submenu_page(
        'woocommerce', // Parent slug
        'Report Extended', // Page title
        'Report Extended', // Menu title
        'manage_options', // Capability
        'report-extended', // Menu slug
        'display_extended_report_page' // Function
    );
}

function display_extended_report_page()
{
    // Set default date range to the year 2024 if not provided
    $date_range = $_POST['date_range'] ?? array('start' => '2024-01-01', 'end' => date('Y-m-d'));

    // Convert dates to string format
    $start_date = date('Y-m-d', strtotime($date_range['start']));
    $end_date = date('Y-m-d', strtotime($date_range['end']));

    // Get all orders
    $orders = wc_get_orders(array(
        'limit' => -1,
        'order' => 'DESC',
        'date_paid' => $start_date . '...' . $end_date
    ));
	
	// Filter out orders with total less than $2
	$filtered_orders = array_filter($orders, function($order) {
		return $order->get_total() > 2;
	});

    $orders_origins = wc_get_orders(array(
        'limit' => -1,
        'order' => 'DESC',
        'date_paid' => $start_date . '...' . $end_date
    ));

    echo '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">';
    echo '<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>';
    echo '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>';
    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">';

    echo '<div class="container mt-5" style="width:95%; max-width:95%;">';
    echo '<h1 class="mb-4 text-primary">Report Extended</h1>';
	
	echo '<h2 class="mb-4 text-primary">Report orders</h2>';
    // Form for date range
    echo '<form method="post" class="mb-3 d-flex">';
    echo '<div class="form-group mr-2">';
    echo '<label for="start-date">Start Date:</label>';
	echo '<input type="date" id="start-date" name="date_range[start]" class="form-control" value="' . $start_date . '">';
	echo '</div>';
	echo '<div class="form-group mr-2">';
	echo '<label for="end-date">End Date:</label>';
	echo '<input type="date" id="end-date" name="date_range[end]" class="form-control" value="' . $end_date . '">';
    echo '</div>';
    echo '<button type="submit" class="btn btn-primary align-self-end" style="margin-bottom: 16px;">Submit</button>';
    echo '</form>';

	if (!empty($filtered_orders)) {
		echo '<table id="sales-data-products" class="table table-striped small-text" style="table-layout: fixed;">';
		echo '<thead class="thead-dark"><tr><th style="width: 3%;">#</th><th style="width: 8%;">Order ID</th><th style="width: 10%;">Date Created</th><th style="width: 15%;">Customer Name</th><th style="width: 20%;">Product</th><th style="width: 7.5%;">Quantity</th><th style="width: 7.5%;">Price</th><th style="width: 15%;">Attribution Source</th><th style="width: 10%;">Status</th><th style="width: 10%;">Opportunity Salesforce</th></tr></thead>';

		echo '<tbody>';
		$count = 1;
		foreach ($filtered_orders as $order) {
			// Check if the order is a refund
if (method_exists($order, 'get_billing_first_name')) {
    $customer_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
    // Check if the customer name is empty (contains only a space)
    if (trim($customer_name) == '') {
        $customer_name = $order->get_billing_email();
    }
} else {
    $customer_name = 'N/A';
}

			// Get and display products
			$items = $order->get_items();
			$order_total = $order->get_total();
			$stripe_net = $order->get_meta('_stripe_net', true) ?: 0;
			$stripe_fee = $order->get_meta('_stripe_fee', true) ?: 0;
			$order_net_total = $stripe_net + $stripe_fee;

			// Use order total if net total is not available
			$comparison_total = ($order_net_total > 0) ? $order_net_total : $order_total;
			$products_total = 0;

			foreach ($items as $item) {
				$products_total += $item->get_total();
			}

			$difference = $comparison_total - $products_total;
			$num_items = count($items);

			if ($difference != 0) {
				$adjustment_per_item = round($difference / $num_items, 2);
				$adjusted_total = 0;
				$remaining_difference = $difference;

				foreach ($items as $index => $item) {
					$original_total = $item->get_total();
					$adjusted_total_item = $original_total + $adjustment_per_item;

					if ($index == $num_items - 1) {
						$adjusted_total_item += $remaining_difference - ($adjustment_per_item * ($num_items - 1));
					}

					if ($adjusted_total_item < 0) {
						$remaining_difference += $adjusted_total_item; // This will be a negative value
						$adjusted_total_item = 0;
					} else {
						$remaining_difference -= $adjustment_per_item;
					}

					$item->set_total($adjusted_total_item);
					$adjusted_total += $adjusted_total_item;
				}

				// If there is any remaining difference, apply it to the last item
				if (abs($adjusted_total - $comparison_total) > 0.01) {
					$last_item = end($items);
					$last_item_adjustment = $comparison_total - $adjusted_total;
					$last_item->set_total($last_item->get_total() + $last_item_adjustment);
				}
			}

			foreach ($items as $item) {
				$domain = get_site_url();
				$attribution_source = $order->get_meta('_wc_order_attribution_utm_source'); // Get and display attribution source
				if($attribution_source ===''){
					$attribution_source = 'Web admin';
				}
				$product_name = str_replace(',', '-', $item->get_name()); // Replace commas in product name with hyphen
				$status_order = $order->get_status(); // Get and display attribution source
				$order_date_created = $order->get_date_created(); // Get and display date created
				$order_date_created_formatted = $order_date_created ? $order_date_created->date_i18n('m-d-Y') : '';

				$id_order = $order->get_id(); // Get and display id
				$order_edit_url = $domain . '/wp-admin/post.php?post=' . $id_order . '&action=edit';

				$opportunity_id = $order->get_meta('mwb_salesforce_Opportunity_id'); // Get salesfroce opportunity
				if (!empty($opportunity_id) && strlen($opportunity_id) === 18) {
					$opportunity_sync_salesforce = 'YES';
				} else {
					$opportunity_sync_salesforce = 'NO';
				}

				if ($id_order < 5999 && $status_order == 'processing') {
					$status_order = "completed";
				}

				echo '<tr>';
				echo '<td>' . $count++ . '</td>';
				echo '<td><a href="' . esc_url($order_edit_url) . '" target="_blank">' . $id_order . '</a></td>';
				echo '<td>' . esc_html($order_date_created_formatted) . '</td>';
				echo '<td>' . $customer_name . '</td>';
				echo '<td>' . $product_name . '</td>';
				echo '<td>' . $item->get_quantity() . '</td>';
				echo '<td>' . $item->get_total() . '</td>';
				echo '<td>' . $attribution_source . '</td>';
				echo '<td>' . $status_order . '</td>';
				if ($opportunity_sync_salesforce === 'YES') {
					echo '<td><a href="https://acue.my.salesforce.com/lightning/r/Opportunity/' . $opportunity_id . '/view" target="_blank">' . $opportunity_sync_salesforce . '</a></td>';
				} else {
					echo '<td>' . $opportunity_sync_salesforce . '</td>';
				}
				echo '</tr>';
			}
		}

		echo '</tbody>';
		echo '</table>';

		// Button to download CSV
		echo '<button id="download-csv" class="btn btn-primary mt-3">Download Orders CSV</button>';
	} else {
		echo '<p>No orders found.</p>';
	}

    echo '<script>
document.getElementById("download-csv").addEventListener("click", function() {
    var csv = [];
    var rows = document.querySelectorAll("#sales-data-products tr");

    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");

        for (var j = 0; j < cols.length; j++) 
            row.push(cols[j].innerText);

        csv.push(row.join(","));        
    }

    downloadCSV(csv.join("\\n"), "report.csv");
});

function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}
</script>';

// Initialize sales data
$sales_data = array();

foreach ($orders_origins as $order_origin) {
    // Get and display attribution source
    $attribution_source = $order_origin->get_meta('_wc_order_attribution_utm_source');

    // Get and display products
    $items = $order_origin->get_items();

    // Update sales data
    foreach ($items as $item) {
        $product_name = $item->get_name();
        $key = $product_name . '|' . $attribution_source;

        if (!isset($sales_data[$key])) {
            $sales_data[$key] = array(
                'product_name' => $product_name,
                'attribution_source' => $attribution_source,
                'total_sold' => 0,
                'total_revenue' => 0.0,
            );
        }

        $sales_data[$key]['total_sold'] += $item->get_quantity();
        $sales_data[$key]['total_revenue'] += $item->get_total();
    }
}

// Sort sales data by product name
uasort($sales_data, function($a, $b) {
    return strcmp($a['product_name'], $b['product_name']);
});

// Display sales data
echo '<h2 class="mt-5 text-primary">Report by Origin</h2>';
echo '<table id="sales-data" class="table table-striped small-text">';
echo '<thead class="thead-dark"><tr><th>Product Name</th><th>Attribution Source</th><th>Total Sold</th><th>Total Revenue</th></tr></thead>';

echo '<tbody>';
foreach ($sales_data as $data) {
    echo '<tr>';
    echo '<td>' . $data['product_name'] . '</td>';
    echo '<td>' . $data['attribution_source'] . '</td>';
    echo '<td>' . $data['total_sold'] . '</td>';
    echo '<td>' . $data['total_revenue'] . '</td>';
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';

// Button to download CSV
echo '<button id="download-csv-sales-data" class="btn btn-primary mt-3">Download Origins CSV</button>';

echo '<script>
document.getElementById("download-csv-sales-data").addEventListener("click", function() {
    var csv = [];
    var rows = document.querySelectorAll("#sales-data tr");

    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");

        for (var j = 0; j < cols.length; j++) 
            row.push(cols[j].innerText);

        csv.push(row.join(","));        
    }

    downloadCSV(csv.join("\\n"), "sales_data.csv");
});

function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}
</script>';

    echo '</div>';
    echo '</div>'; 
	echo '<style> #wpfooter{display:none; !important}</style>';
}