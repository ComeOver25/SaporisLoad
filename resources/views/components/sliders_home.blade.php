<div class="mdslider">
    <ul class="navigation">
        <li><a href="#" id="md_slider_nav_prew"><i class="fa-solid fa-angle-left"></i></a></li>
        <li><a href="#" id="md_slider_nav_next"><i class="fa-solid fa-angle-right"></i></a></li>
    </ul>
    @foreach($sliders as $slider)
    <div class="md-slider-item">
        <div class="row">
            <div class="col-md-5 col-12">
                <div class="content">
                    <div class="cinside">
                        {!! html_entity_decode($slider->content) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-12">               
                <a href="{{getUrlFileFromUploads($slider->file_name)}}" data-fancybox="gallery">
                    <img src="{{getUrlFileFromUploads($slider->file_name,'1000x1000')}}" class="img-fluid">                            
                </a>
            </div>
        </div>
    </div> 
    @endforeach  
</div>