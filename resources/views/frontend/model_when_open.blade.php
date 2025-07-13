@if(get_general_value('popup_status') == 1)
<div class="page-load-modal">
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="popupModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                <!-- زر الإغلاق -->
                <button type="button" class="btn-close position-absolute top-3 end-3 zindex-tooltip" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="modal-body p-4 text-center bg-light" style="background-color: {{ get_general_value('popup_bg_color', '#ffffff') }} !important;">

                    <!-- الصورة بشكل دائري مع ظل -->
                    <div class="popup-img mb-4 mx-auto" style="width: 140px; height: 140px; overflow: hidden; border-radius: 50%; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                        <img src="{{ Storage::url(get_general_value('popup_image')) }}" alt="Popup Image" class="w-100 h-100 object-fit-cover">
                    </div>

                    <!-- العنوان -->
                    <h3 class="popup-title fw-bold mb-3 text-primary">{{ get_general_value('popup_title_'.app()->getLocale()) }}</h3>

                    <!-- زر الرابط بتأثير hover -->
                    <a href="{{ get_general_value('popup_link') }}" target="_blank"
                       class="btn btn-outline-primary btn-lg px-5 fw-semibold"
                       style="transition: all 0.3s ease;">
                        {{ get_general_value('popup_button_text_'.app()->getLocale()) }}
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endif
