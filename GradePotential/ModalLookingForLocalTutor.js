// Dynamically create the modal with styles and content
(function createModal() {
  // Modal styles
  const styles = `
        
         .modal-backdrop {
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.5s ease, visibility 0.5s ease;
          }
          .modal-backdrop.show {
            opacity: 1;
            visibility: visible;
          }
          .modal-container {
            width: 760px;
            height: 497px;
            background: white;
            border-radius: 30px; 
            position: relative;
            overflow: hidden;
            display: flex;
          }
          .modal-image {
            width: 348px;
            height: 100%;
            border-top-left-radius: 30px;
            border-bottom-left-radius: 30px;
            object-fit: cover;
          }
          .modal-content {
            color: rgb(0, 27, 114);
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
          }
          .modal-title {
            width: 250px;
            font-family: Lato;
            font-weight: 700;
            font-style: normal;
            font-size: 36px;
            line-height: 38px;
            margin-bottom: 10px;
          }
          .modal-text {
            width: 300px;
            margin-top: 10px;
            font-family: Lato;
            font-weight: 400;
            font-style: normal;
            font-size: 28px;
            line-height: 34px;
          }
          .call-button {
            margin-top: 30px;	
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #e50029;
            color: white;
            font-family: Lato;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 20px;
            transition: background-color 0.3s;
          }
          .call-button img {
            width: 21px;
            height: 21px;
            margin-right: 10px;
          }
          .call-button:hover {
            background-color: #bf0023;
          }
          .close-button {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            color: black;
            background: none;
            border: none;
            cursor: pointer;
          }
           /* Add media queries for responsive design */
            @media (max-width: 767.98px) {
              .modal-container {
                width: 80%; 
                height: auto; 
                flex-direction: column; 
                border-radius: 0 0 30px 30px; 
              }
              .modal-image {
                width: 100%; 
                height: 300px; 
                border-radius: 0;
                object-fit: cover;
              }
                .image-section {
                  margin-bottom: -50px;
              }
              .modal-content {
                padding: 30px 40px 30px 40px; 
                align-items: center; 
                text-align: center; 
                border-radius: 30px;
                background-color: #fff;
                font-weight: 400;
                font-family: Lato;
                font-size: 28px;
                color: rgb(0, 27, 114);
                font-style: normal;
              }
              .modal-title {
                width: auto; 
                font-family: Lato;
                font-weight: 700;
                font-style: normal;
                font-size: 25px;
                text-align: left;
                line-height: 20px;
              }
              .modal-text {
                width: auto; 
                font-size: 16px; 
                line-height: 22px; 
                text-align: left;
              }
              .call-button {
                font-size: 14px; 
                padding: 10px 15px; 
                border-radius: 15px; 
                height: 35px;
              }
              .close-button {
                top: 10px;
                right: 10px;
                font-size: 18px; 
                color: #454545;
                width: 20px;  
                height: 20px;  
                background-color: #ffffff99;
                border-radius: 50%;
              }
            }
      `;

  // Insert styles into the document
  const styleElement = document.createElement("style");
  styleElement.type = "text/css";
  styleElement.textContent = styles;
  document.head.appendChild(styleElement);

  // Mondal content
  const modalHTML = `
        <div class="modal-backdrop" id="modal-backdrop">
          <div class="modal-container">
            <div class="image-section">
              <button class="close-button" onclick="document.getElementById('modal-backdrop').remove()">&times;</button>
               <img class="modal-image" src="https://d9hhrg4mnvzow.cloudfront.net/a2d59bc046594f0297c0612c21f4aebd.pages.ubembed.com/c3e6f477-4bca-4f33-9d1b-ec9fd5e4cd3e/d275d07d-smiling-african-american-boy-sitting-table-discussing-examples-with-tutor-individual-l_10bj0e009o0e000x000028.png" alt="Tutor Image">
              </div>
            
           
            <div class="modal-content">
              <h2 class="modal-title">We'll send a great tutor to your house!</h2>
              <p class="modal-text">Give us a call, and we'll match you with the perfect tutor!</p>
              <div class="call-button"> 
                <img src="https://d9hhrg4mnvzow.cloudfront.net/a2d59bc046594f0297c0612c21f4aebd.pages.ubembed.com/c3e6f477-4bca-4f33-9d1b-ec9fd5e4cd3e/737fbc53-phone_100l00l000000000000028.png" alt="Phone Icon">
                <p class="multi-number-replace" style="color:#ffffff; text-decoration: underline; font-size: 16px; font-weight: bolder; font-family: Lato;">
                    (Loading...)
                </p>
              </div>  
            </div>
          </div>
        </div>
      `;

  // Insert the modal into the body of the document
  const modalContainer = document.createElement("div");
  modalContainer.innerHTML = modalHTML;
  document.body.appendChild(modalContainer);

  // Show the modal after 5 seconds
  setTimeout(() => {
    const modalBackdrop = document.getElementById("modal-backdrop");
    modalBackdrop.classList.add("show");
  }, 5000);
})();
