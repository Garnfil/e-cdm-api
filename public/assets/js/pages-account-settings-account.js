/**
 * Account Settings - Account
 */

'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    const deactivateAcc = document.querySelector('#formAccountDeactivation');

    // Update/reset user image of account page
    let accountUserImage = document.getElementById('uploadedAvatar');
    const fileInput = document.querySelector('.account-file-input'),
      resetFileInput = document.querySelector('.account-image-reset');

    if (accountUserImage) {
      const resetImage = accountUserImage.src;
      fileInput.onchange = () => {
        if (fileInput.files[0]) {
          accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);

          const formData = new FormData();
          formData.append('profileImage', fileInput.files[0]);


          $.ajax({
            url: '/api/upload-profile-image', // Replace with your server-side endpoint
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
              $('#uploadStatus').text('Upload successful!');
              console.log('Response:', response);
            },
            error: function (xhr, status, error) {
              $('#uploadStatus').text('Failed to upload image.');
              console.error('Error:', error);
            }
          });
        }
      };
      resetFileInput.onclick = () => {
        fileInput.value = '';
        accountUserImage.src = resetImage;
      };
    }
  })();
});
