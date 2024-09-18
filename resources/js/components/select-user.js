const SelectUser = {
    $domPopup: document.getElementById('success-popup'),
    $domBody: document.body,
    $domSuccessMessageMeta: document.querySelector('meta[name="success-message"]'),


    init: function() {
        if (SelectUser.$domSuccessMessageMeta) {
            this.showPopup();
            this.setupPopupTimeout();
        }
    },

    showPopup: function() {
        SelectUser.$domPopup.classList.remove('hidden');
        SelectUser.$domBody.classList.add('no-scroll'); // Disable scrolling
    },

    hidePopup: function() {
        SelectUser.$domPopup.classList.add('fade-out');
        setTimeout(() => {
            SelectUser.$domPopup.classList.add('hidden');
            SelectUser.$domPopup.classList.remove('fade-out');
            SelectUser.$domBody.classList.remove('no-scroll'); // Enable scrolling
        }, 1000); // Duration of the fade-out animation
    },

    setupPopupTimeout: function() {
        setTimeout(() => {
            this.hidePopup();
        }, 2500); // Time to keep the popup visible before starting fade-out
    },
};

SelectUser.init();
