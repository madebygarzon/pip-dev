  function addModal() {
    const modalContainer = document.createElement('div');
    const modalContent = document.createElement('div');
    const closeButton = document.createElement('span');
    const ubNumbers = document.getElementById('lp-pom-text-255').innerHTML;

    modalContainer.classList.add('modal');
    modalContent.classList.add('modal-content');
    closeButton.classList.add('close-button');

    modalContent.appendChild(closeButton);
    modalContainer.appendChild(modalContent);
    document.body.appendChild(modalContainer);

    modalContent.innerHTML += '<p class="modal-headline"><span>Call now</span> to get all your questions answered</p>'
      + '<p class="modal-subhead">(We\'re really friendly! You\'ll love us!)</p>'
      + '<div class="dynamic-numbers">' + ubNumbers.replace(/(\|| )/g, '') + '</div>'

    function showModal() {
      modalContainer.classList.add('show-modal');
    }
    function hideModal() {
      modalContainer.classList.remove('show-modal');
    }
    setTimeout(showModal, 15000);

    function windowOnClick(event) {
      if (event.target === modalContainer) {
        hideModal();
      }
    }

    document.querySelector('.close-button').addEventListener('click', hideModal);
    document.querySelector('.close-button').addEventListener('touchstart', hideModal);
    window.addEventListener('click', windowOnClick);
    window.addEventListener('touchstart', windowOnClick);
  }
  addModal();
