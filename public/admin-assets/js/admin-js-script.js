$(document).ready(function () {
    $('#doc_comment_textarea').hide();

    $('#show-view-doc-options').on('change', function () {
        var selectedValue = $(this).val();
        var docCommentTextarea = $('#doc_comment_textarea');

        if (selectedValue === '3') {
            docCommentTextarea.show();
            docCommentTextarea.val(''); // Clear any existing text
            docCommentTextarea.val('Document rejected by admin.');
        } else if (selectedValue === '4') {
            docCommentTextarea.show();
            // Add the "Document approved by admin" text
            // You can change the text as needed
            docCommentTextarea.val('Document approved by admin');
        }else if (selectedValue === '5') {
            // Use SweetAlert for the confirmation prompt
            Swal.fire({
                title: 'Request Final Approval',
                text: 'Are you sure you want to request final approval?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                    docCommentTextarea.show();
                    docCommentTextarea.val('Request for final approval');
                } else {
                    // If the user cancels, reset the selected option
                    $(this).val('0'); // Change '0' to the default option value
                    docCommentTextarea.hide();
                    docCommentTextarea.val(''); // Clear any existing text
                }
            });
        } 
        else {
            docCommentTextarea.hide();
            docCommentTextarea.val(''); // Clear any existing text
            docCommentTextarea.val('Document rejected by admin.');
        }
    });

    // Add character validation for docCommentTextarea
    $('#doc_comment_textarea').on('input', function () {
        var maxLength = 100; // Maximum character length
        var currentLength = $(this).val().length;
        if (currentLength > maxLength) {
            // Trim the input text to the maximum length
            $(this).val($(this).val().substr(0, maxLength));

            // Display a SweetAlert notification when the character limit is reached
            Swal.fire({
                icon: 'error',
                title: 'Character Limit Exceeded',
                text: 'You have reached the maximum character limit (100).',
            });

             // Disable the submit button
             $('#adminSubmitBtn').prop('disabled', true);

        }else{
            $('#adminSubmitBtn').prop('disabled', false);
        }
    });

    $('#show-view-doc-options1').bind('input', function () {
        var c = this.selectionStart,
            r = /[^a-z0-9 .]/gi,
            v = $(this).val();
        if (r.test(v)) {
            $(this).val(v.replace(r, ''));
            c--;
        }
        this.setSelectionRange(c, c);
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("adminNcForm"); // Change this to your form's actual ID
    const submitBtn = document.getElementById("adminSubmitBtn"); // Change this to your button's actual ID

    form.addEventListener("submit", function () {
        submitBtn.disabled = true; // Disable the button when the form is submitted
    });
});
