<script src="{{ asset('backend/app-assets/vendors/js/vendors.min.js') }}" type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script type="text/javascript" src="{{ asset('backend/app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/app-assets/vendors/js/charts/jquery.sparkline.min.js') }}">
</script>
<script src="{{ asset('backend/app-assets/vendors/js/charts/chart.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/charts/raphael-min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/charts/morris.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/charts/jvector/jquery-jvectormap-2.0.3.min.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/charts/jvector/jquery-jvectormap-world-mill.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/data/jvector/visitor-data.js') }}" type="text/javascript"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN MODERN JS-->
<script src="{{ asset('backend/app-assets/js/core/app-menu.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/js/core/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/js/scripts/customizer.js') }}" type="text/javascript"></script>
<!-- END MODERN JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script type="text/javascript" src="{{ asset('backend/app-assets/js/scripts/ui/breadcrumbs-with-stats.js') }}">
</script>
<script src="{{ asset('backend/app-assets/js/scripts/pages/dashboard-sales.js') }}" type="text/javascript"></script>
{{-- <script src="{{ asset('backend/app-assets/vendors/js/forms/select/selectivity-full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/js/scripts/forms/select/form-selectivity.js') }}" type="text/javascript"></script> --}}

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


<script src="{{ asset('backend/app-assets/vendors/js/tables/datatable/datatables.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('backend/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js') }}"
    type="text/javascript"></script>
@if (app()->getLocale() == 'en')
    <script src="{{ asset('backend/app-assets/js/scripts/tables/datatables/datatable-advanced.js') }}"
        type="text/javascript"></script>
@else
    <script src="{{ asset('backend/app-assets/js/scripts/tables/datatables/datatable-advancedar.js') }}"
        type="text/javascript"></script>
@endif
<script src="{{ asset('backend/app-assets/vendors/js/extensions/sweetalert.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('backend/app-assets/vendors/js/extensions/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/js/scripts/extensions/toastr.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/custom-js/custom.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/extensions/jquery.steps.min.js') }}" type="text/javascript">
</script>

<!-- END PAGE VENDOR JS-->
<script src="{{ asset('backend/app-assets/js/scripts/forms/wizard-steps.js') }}" type="text/javascript"></script>
</script>
<script src="{{ asset('backend/app-assets/vendors/js/forms/tags/tagging.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/js/scripts/forms/tags/tagging.js') }}" type="text/javascript"></script>
<!-- jQuery (Required for Toastr) -->
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (document.getElementById("editor")) {
            CKEDITOR.replace("editor", {
                height: 200,
            });

            document.querySelector("form").addEventListener("submit", function(e) {
                let editor = CKEDITOR.instances.editor;
                if (editor) {
                    let editorData = editor.getData().trim();
                    let errorMsg = document.getElementById("editor-error");

                    if (!editorData) {
                        e.preventDefault();
                        errorMsg.style.display = "block";
                    } else {
                        errorMsg.style.display = "none";
                    }
                }
            });
        }
    });
</script>




<script>
    $(document).ready(function() {
        @if (session('toastr_success'))
            toastr.success("{{ session('toastr_success') }}");
        @endif

        @if (session('toastr_error'))
            toastr.error("{{ session('toastr_error') }}");
        @endif
    });
</script>

<script>
    $(document).ready(function() {
        $('#image').on('change', function() {
            let reader = new FileReader();

            reader.onload = function(e) {
                $('.image-preview').attr('src', e.target.result);
            };

            if (this.files && this.files[0]) {
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>

<script>
    $(".imagee").change(function() {

        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.image-previeww').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);
        }

    });
    $('.delete-confirm').click(function(event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
                title: `هل متأكد من حذف العنصر ؟`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
    });
</script>

<script></script>


<script>
    let elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

    elems.forEach(function(html) {
        let switchery = new Switchery(html, {
            size: 'small'
        });
    });
</script>

@yield('script')


<script>
    $(document).ready(function() {
        @if (!Route::is('products.index') && !Route::is('categories.index') && !Route::is('coupons.index'))
            @if (app()->getLocale() == 'ar')
                $('table').DataTable({
                    language: {
                        "sProcessing": "جاري التحميل...",
                        "sLengthMenu": "أظهر _MENU_ مدخلات",
                        "sZeroRecords": "لم يعثر على أية سجلات",
                        "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                        "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
                        "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                        "sInfoPostFix": "",
                        "search": "<span class='search-label'><i class='la la-search'></i> ابحث</span>:",
                        "sUrl": "",
                        "oPaginate": {
                            "sFirst": "الأول",
                            "sPrevious": "السابق",
                            "sNext": "التالي",
                            "sLast": "الأخير"
                        },

                    },

                    direction: 'rtl'
                });
            @else
                $('table').DataTable({
                    language: {
                        "sProcessing": "טוען...",
                        "sLengthMenu": "הצג _MENU_ רשומות",
                        "sZeroRecords": "לא נמצאו רשומות תואמות",
                        "sInfo": "מציג _START_ עד _END_ מתוך _TOTAL_ רשומות",
                        "sInfoEmpty": "מציג 0 עד 0 מתוך 0 רשומות",
                        "sInfoFiltered": "(מסונן מתוך _MAX_ רשומות סה\"כ)",
                        "sInfoPostFix": "",
                        "search": "<span class='search-label'><i class='la la-search'></i> חיפוש</span>:",
                        "sUrl": "",
                        "oPaginate": {
                            "sFirst": "ראשון",
                            "sPrevious": "קודם",
                            "sNext": "הבא",
                            "sLast": "אחרון"
                        },
                        "oAria": {
                            "sSortAscending": ": הפעל למיון עולה",
                            "sSortDescending": ": הפעל למיון יורד"
                        }
                    },
                    direction: 'rtl' // يمكن تغييرها إلى 'ltr' إذا كنت تفضل الاتجاه من اليسار لليمين
                });
            @endif
        @endif

    });
</script>

<!-- END PAGE LEVEL JS-->
</body>

</html>
