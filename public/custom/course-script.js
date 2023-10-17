
$(document).ready(function () {
    $('.select2').select2();




    $(document).on("click", "#view", function () {

        var UserName = $(this).data('id');
        console.log(UserName);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ url('course-list') }}",
            type: "get",
            data: {
                id: UserName
            },
            success: function (data) {


                console.log(data.ApplicationCourse[0].eligibility)
                console.log(data.Document[0].document_file)

                $("#Course_id").val(data.ApplicationCourse[0].id);
                $("#Course_Name").val(data.ApplicationCourse[0].course_name);
                $("#Eligibility").val(data.ApplicationCourse[0].eligibility);
                $("#Mode_Of_Course").val(data.ApplicationCourse[0].mode_of_course);
                if (data.ApplicationCourse[0].payment == "false") {
                    $("#Payment_Status").val("Pending");
                }
                $("#view_course_brief").text(data.ApplicationCourse[0].course_brief);


                $("#view_years").html(data.ApplicationCourse[0].years + " Year(s)");
                $("#view_months").html(data.ApplicationCourse[0].months + " Month(s)");
                $("#view_days").html(data.ApplicationCourse[0].days + " Day(s)");
                $("#view_hours").html(data.ApplicationCourse[0].hours + " Hour(s)");

                //alert(data.Document[2].document_file);

                $("a#docpdf1").attr("href", "{{ url('show-course-pdf') }}" + '/' + data.Document[
                    0]
                    .document_file);
                $("a#docpdf2").attr("href", "{{ url('show-course-pdf') }}" + '/' + data.Document[
                    1]
                    .document_file);

                $("a#docpdf3").attr("href", "{{ asset('/documnet') }}" + '/' + data.Document[2]
                    .document_file);
                /*$("a#docpdf3").attr("href", "{{ url('show-course-pdf') }}" + '/' + data.Document[2]
                    .document_file);*/




            }

        });

    });

    $(document).on("click", "#edit_course", function () {

        var offline_checkbox = $('#offline_checkbox').val();
        var online_checkbox = $('#online_checkbox').val();
        var hybrid_checkbox = $('#hybrid_checkbox').val();

        //alert("edit course second 2420");
        var UserName = $(this).data('id');
        console.log(UserName);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ url('course-edit') }}",
            type: "get",
            data: {
                id: UserName
            },
            success: function (data) {



                var values = data.ApplicationCourse[0].mode_of_course;
                $.each(values, function (i, e) {
                    $("#mode_of_course_edit option[value='" + e + "']").prop("selected",
                        true);
                });

                $('#form_update').attr('action', '{{ url(' / course - edit') }}' + '/' + data
                    .ApplicationCourse[0].id)
                $("#Course_Names").val(data.ApplicationCourse[0].course_name);
                $("#Eligibilitys").val(data.ApplicationCourse[0].eligibility);

                const checkboxes = document.querySelectorAll('input[type="checkbox"][name="mode_of_course[]"]');
                var modeOfCourseItems = data.ApplicationCourse[0].mode_of_course;

                checkboxes.forEach(checkbox => {
                    if (modeOfCourseItems.includes(checkbox.value)) {
                        checkbox.checked = true;
                    } else {
                        checkbox.checked = false;
                    }
                });




                if (data.ApplicationCourse[0].payment == "false") {
                    $("#Payment_Statuss").val("Pending");
                }

                $("#years").val(data.ApplicationCourse[0].years);
                $("#months").val(data.ApplicationCourse[0].months);
                $("#days").val(data.ApplicationCourse[0].days);
                $("#hours").val(data.ApplicationCourse[0].hours);
                $("#course_brief").val(data.ApplicationCourse[0].course_brief);

                //$("#doc1_edit").val(data.Document[0].document_file);



                //alert("yes");
                $("a#docpdf1ss").attr("href", "{{ url('show-course-pdf') }}" + '/' + data
                    .Document[0]
                    .document_file);
                $("a#docpdf2ss").attr("href", "{{ url('show-course-pdf') }}" + '/' + data
                    .Document[1]
                    .document_file);
                /*$("a#docpdf1ss").attr("href", "{{ asset('/documnet') }}" + '/' + data.Document[0]
                    .document_file);
                $("a#docpdf2ss").attr("href", "{{ asset('/documnet') }}" + '/' + data.Document[1]
                    .document_file);*/
                $("a#docpdf3ss").attr("href", "{{ asset('/documnet') }}" + '/' + data.Document[2]
                    .document_file);

                //dd
            }

        });

    });

    var isAppending = false; // Flag to prevent multiple append requests
    var cloneCounter = 1;

    function addNewCourse() {
        if (!isAppending) {
            isAppending = true;

            // Clone the template row
            var newRow = $('#new_course_html').clone();

            // Clear input fields and remove any unwanted attributes
            newRow.find('input, textarea').val('');
            newRow.find('input[type="file"]').removeAttr('id').val('');

            // Remove the ID attribute from the remove button
            newRow.find('.remove-course').removeAttr('id');

            // Show the remove button for the new row
            newRow.find('.remove-course').show();

            // Increment the cloneCounter for unique IDs
            cloneCounter++;

            // Update the name attribute of the mode_of_course select field
            var modeOfCourseSelect = newRow.find('.select2[name^="mode_of_course[1]"]');
            modeOfCourseSelect.attr('name', `mode_of_course[${cloneCounter}][]`);

            $("#mode-of-course-edit").select2({
                placeholder: "Select a programming language",
                allowClear: true
            });
            // Reset Select2 for the cloned select element
            modeOfCourseSelect.select2();
            modeOfCourseSelect.select2('destroy'); // Destroy the previous instance

            // Add a class to the new row
            newRow.addClass('new-course-html');

            // Append the new row to the container
            $('.new-course-row').append(newRow); // Append to the existing .new-course-row div


            // add top border
            $('.new-course-html:last-child').css('border-top', '1px solid #ccc');

            // add bottom border
            $('.new-course-html:last-child').css('border-bottom', '1px solid #ccc');

            // add left border
            $('.new-course-html:last-child').css('border-left', '1px solid #ccc');

            // add right border
            $('.new-course-html:last-child').css('border-right', '1px solid #ccc');

            // add top and bottom padding 10px;
            $('.new-course-html:last-child').css('padding-top', '10px');
            $('.new-course-html:last-child').css('padding-bottom', '10px');

            // add left and right padding 10px;
            $('.new-course-html:last-child').css('padding-left', '5px');
            $('.new-course-html:last-child').css('padding-right', '5px');

            // add top and bottom margin 10px;
            $('.new-course-html:last-child').css('margin-top', '10px');
            $('.new-course-html:last-child').css('margin-bottom', '10px');


            // Append the hidden input elements
            // Manually set values for "application_id" and "level_id"

            // Set the values for "application_id" and "level_id"
            var applicationId = '{{ $applicationData->id ?? '' }}';
            var levelId = '{{ $applicationData->level_id ?? '' }}';

            newRow.find('input[name="application_id"]').val(applicationId);
            newRow.find('input[name="level_id"]').val(levelId);


            newRow.append('<input type="hidden" name="country" value="{{ $data->country ?? '' }}">');
            newRow.append('<input type="hidden" name="state" value="{{ $data->state ?? '' }}">');

            $('.select2').select2();

            $('.select2-selection--single').hide();


            isAppending = false; // Reset the flag
        }
    }

    function removeCourse(button) {
        // Find the parent row and remove it
        $(button).closest('.new-course-html').remove();
    }

    function confirmDelete(deleteUrl) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user confirms, proceed with the delete operation by navigating to the delete URL
                window.location.href = deleteUrl;
            }
        });
    }


    var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
        removeItemButton: true,
        maxItemCount: 3,
        searchResultLimit: 5,
        renderChoiceLimit: 5
    });



    var doc_file1 = "";

    $('.doc_1').on('change', function () {

        doc_file1 = $(".doc_1").val();
        console.log(doc_file1);
        var doc_file1 = doc_file1.split('.').pop();
        if (doc_file1 == 'pdf') {
            // alert("File uploaded is pdf");
        } else {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Validation error!',
                text: 'Only PDF files are allowed',
                showConfirmButton: false,
                timer: 3000
            })
            $('.doc_1').val("");
        }

    });

    var doc_file2 = "";
    $('.doc_2').on('change', function () {

        doc_file2 = $(".doc_2").val();
        console.log(doc_file2);
        var doc_file2 = doc_file2.split('.').pop();
        if (doc_file2 == 'pdf') {
            // alert("File uploaded is pdf");
        } else {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Validation error!',
                text: 'Only PDF files are allowed',
                showConfirmButton: false,
                timer: 3000
            })
            $('.doc_2').val("");
        }

    });

    var doc_file3 = "";
    $('.doc_3').on('change', function () {

        doc_file3 = $(".doc_3").val();
        console.log(doc_file3);
        var doc_file3 = doc_file3.split('.').pop();


        if (doc_file3 == 'csv' || doc_file3 == 'xlsx' || doc_file3 == 'xls') {
            // alert("File uploaded is pdf");
        } else {
            //  alert("Only csv,xlsx,xls  are allowed")
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Validation error!',
                text: 'Only csv,xlsx, and xlsx are allowed',
                showConfirmButton: false,
                timer: 3000
            })
            $('.doc_3').val("");
        }

    });

});
