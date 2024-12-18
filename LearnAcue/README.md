# Learn Acue 

[Learn Acue](https://learn.acue.org/) is a project designed using the WordPress platform. This website offers personalized tutoring services, prioritizing an intuitive and professional experience for its users.

## Project Description

....

## Key Features

- **Responsive design**: Ensures an optimized experience across all devices.
- **Custom integrations**: Uses tailored scripts for advanced features.
- **Conversion-focused**: Unbounce tools designed to maximize engagement.

## Custom Scripts

The website incorporates several custom scripts to enrich the user experience. Below is a general overview of the implemented scripts:

1. **Report Extended**:
   This PHP script [Report Extended](https://github.com/madebygarzon/pip-dev/blob/main/LearnAcue/ReportExtended.php) integrates into the WordPress WooCommerce admin panel to provide an extended report page for orders. The primary focus is to allow administrators to view, filter, and download detailed sales data based on specific date ranges. Below is a summary of its functionality:
   [Ubication](https://learn.acue.org/wp-admin/admin.php?page=edit-snippet&id=33)  
   

    ### Key Features

    1.1. **WooCommerce Submenu Integration**:
   - Adds a new submenu under the "WooCommerce" menu titled **"Report Extended"**.
   - Links to a custom admin page displaying the extended report.

    1.2. **Date Range Filtering**:
    - Administrators can filter orders using a customizable date range.
    - Defaults to the year **2024** if no date range is provided.

    1.3. **Order Data Display**:
    - Fetches WooCommerce orders within the specified date range and filters out orders with a total value less than `$2`.
    - Displays detailed order information in a table, including:
        - **Order ID**: Linked to the edit page.
        - **Date Created**.
        - **Customer Name**: Fallbacks to email if the name is unavailable.
        - **Product Details**: Name, quantity, and price.
        - **Status**: Adjusted for specific conditions.
        - **Attribution Source**: E.g., UTM parameters.
        - **Salesforce Opportunity Status**: Linked if synced.

    1.4. **Sales Data by Attribution Source**:
    - Aggregates and displays sales data by product and marketing attribution source.
    - Includes metrics such as:
        - Product name.
        - Attribution source.
        - Total units sold.
        - Total revenue.

    1.5. **Order Total Adjustments**:
    - Identifies discrepancies between order totals and product-level totals.
    - Adjusts product totals to match the net order total.

    1.6. **Export to CSV**:
    - Offers two CSV download options:
        - **Order Details**: Includes all detailed order data.
        - **Sales by Attribution**: Aggregated sales data by product and source.
    - Uses JavaScript to dynamically generate and download the CSV files.

    1.7. **Bootstrap UI Integration**:
    - Leverages Bootstrap for styling forms, tables, and buttons.
    - Provides a clean, responsive, and user-friendly interface.

    1.8. **Responsive Design**:
    - Ensures compatibility with various screen sizes for better usability.

    ### Use Case

    This script is designed for WooCommerce store administrators who need:
    - A **custom reporting tool** to analyze order details and sales performance.
    - Insights into sales by attribution sources (e.g., marketing campaigns).
    - An easy way to **export data** for external analysis or reporting.

    ### Requirements

    - **WooCommerce**: Must be installed and active.
    - **Custom Metadata**: Relies on WooCommerce metadata such as `_stripe_net` and `_wc_order_attribution_utm_source`.
    - **Salesforce Integration**: Supports Salesforce fields like `mwb_salesforce_Opportunity_id` for tracking opportunities. Adjustments may be necessary if Salesforce is not used.

    ### Setup

    - Add the script to your WordPress plugin or theme's functions file.
    - Access the **"Report Extended"** submenu under the WooCommerce menu in the admin panel.


## Project Structure

This project follows Unbounce's standard development structure, with scripts and configurations managed directly within the platform. Key areas of customization are as follows:

- **Landing pages**: Each page has a unique design tailored to different marketing objectives.
- **Script configurations**: Custom scripts are set up in the global or page-specific script sections within Unbounce.
- **Additional resources**: Multimedia files (images and videos) uploaded directly to Unbounce.

## How to Contribute

This project's development is centralized in the Unbounce platform. To suggest improvements or new features:

1. Contact the project's development team.
2. Provide clear details about the proposed functionality or enhancement.
3. If submitting a custom script, include well-documented code to facilitate integration.

