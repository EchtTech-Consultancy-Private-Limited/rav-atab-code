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
        } else {
            docCommentTextarea.hide();
            docCommentTextarea.val(''); // Clear any existing text
            docCommentTextarea.val('Document rejected by admin.');
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
