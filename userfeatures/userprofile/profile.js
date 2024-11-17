$(document).ready(function() {
    // Adjust container visibility with proper transitions
    $('#editIcon').click(function() {
        $('#profileContainer').fadeOut(300, function() {
            $('#editProfileContainer').removeClass('d-none').hide().fadeIn(300);
        });
    });

    // Handle window resize for responsive adjustments
    $(window).resize(function() {
        adjustContainerSpacing();
    });

    // Initial call to adjust spacing
    adjustContainerSpacing();

    // Function to adjust container spacing based on screen size
    function adjustContainerSpacing() {
        if (window.innerWidth <= 768) { // Mobile breakpoint
            $('.profile-and-feed').addClass('mobile-spacing');
            $('.edit-profile-container').addClass('mobile-spacing');
        } else {
            $('.profile-and-feed').removeClass('mobile-spacing');
            $('.edit-profile-container').removeClass('mobile-spacing');
        }
    }

    const form = document.querySelector("form");
    const cancelBtn = document.getElementById("cancelEdit");
    let originalName = document.getElementById("editName").value;
    let originalEmail = document.getElementById("editEmail").value;

    // Function to get the query parameter from the URL
    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    // Check for message in the URL
    const message = getQueryParam('message');

    if (message === "success") {
        Swal.fire({
            title: "Profile Updated Successfully",
            icon: 'success',
            confirmButtonText: 'Okay',
            confirmButtonColor: "green" // Set the "OK" button background color to green
        });
    } else if (message === "username_error") {
        Swal.fire({
            title: "Username already exists. Please choose another.",
            icon: 'error',
            confirmButtonText: 'Okay',
            confirmButtonColor: "green" // Set the "OK" button background color to green
        });
    } else if (message === "email_error") {
        Swal.fire({
            title: "Email already exists. Please choose another.",
            icon: 'error',
            confirmButtonText: 'Okay',
            confirmButtonColor: "green" // Set the "OK" button background color to green
        });
    }

    cancelBtn.addEventListener("click", function () {
        // Redirect smoothly to profile.php
        window.location.href = "profile.php";
    });

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent the default form submission

        const newName = document.getElementById("editName").value;
        const newEmail = document.getElementById("editEmail").value;
        const newPassword = document.getElementById("editPassword").value;

        // Check if any changes were made
        if (newName === originalName && newEmail === originalEmail && !newPassword) {
            // No changes made, redirect smoothly
            window.location.href = "profile.php";
        } else {
            // Submit the form
            form.submit();
        }
    });
});


function uploadImage(event) {
    const fileInput = event.target;
    const formData = new FormData();
    const file = fileInput.files[0];

    if (file) {
        formData.append('profile_image', file);

        // Send an AJAX request to upload the profile picture
        fetch('update_profile_picture.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.text())
        .then(data => {
            if (data.includes("Profile picture updated successfully")) {
                Swal.fire({
                    icon: 'success',
                    title: 'Profile Updated',
                    text: 'Your profile picture has been updated successfully!',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok',
                    background: '#f0f8ff', // Light background for a refreshing feel
                    backdrop: `
                        rgba(0, 0, 0, 0.5)
                        url('../../../images/login-bg.jpg') // Add a mountain-themed backdrop image
                        center top
                        no-repeat
                    `,
                    customClass: {
                        title: 'swal-title', // Custom class for the title
                        content: 'swal-content', // Custom class for the content
                        confirmButton: 'swal-confirm-button' // Custom class for the button
                    },
                    footer: '<span style=\"color: gray;\">Thank you for updating your profile!</span>',
                    willClose: () => {
                        // Reload the page to reflect the updated profile picture
                        location.reload();
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Update Failed',
                    text: data, // Display the error message from the server
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ok'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while updating the profile picture. Please try again later.',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ok'
            });
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'No File Selected',
            text: 'Please choose an image file to upload.',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ok'
        });
    }
}

document.getElementById('deleteAccountBtn').addEventListener('click', function() {
    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone. All your data will be permanently deleted.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete my account',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Make AJAX call to delete account
            $.ajax({
                url: 'delete_account.php',
                type: 'POST',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Account Deleted',
                            text: 'Your account has been successfully deleted.',
                            icon: 'success',
                            confirmButtonColor: '#3085d6'
                        }).then(() => {
                            window.location.href = '../../login.php';
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.message || 'Failed to delete account. Please try again.',
                            icon: 'error',
                            confirmButtonColor: '#3085d6'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Something went wrong. Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#3085d6'
                    });
                }
            });
        }
    });
});

