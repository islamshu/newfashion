 <div class="top-bar">
     <div class="container">
         <div class="row">
             <div class="col-lg-12 d-flex align-items-center justify-content-between gap-3">
                 <div class="top-bar-left">
                 </div>
                 <div class="company-logo">
                     <a href="/">
                         <img src="{{ Storage::url(get_general_value('website_logo')) }}" height="100" width="100"
                             alt="{{ get_general_value('website_name_' . app()->getLocale()) }}"></a>
                 </div>
                 <div class="search-area" style="position:relative;">
    <form>
        <div class="form-inner">
            <input type="text" placeholder="Search..." />
            <button type="submit"><i class="bx bx-search"></i></button>
        </div>
    </form>

    <!-- صندوق النتائج -->
    <div id="searchResults" class="search-results-box" style="display:none;"></div>
</div>

                 </div>

             </div>
         </div>
     </div>
 </div>
