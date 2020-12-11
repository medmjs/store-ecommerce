@extends('layouts.admin')

@section('content')



  <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item"><a href="">
                                        Slider </a>
                                </li>
                                <li class="breadcrumb-item active"> أضافه صور سلايدير
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form"> أضافة منتج جديد </h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                @include('dashboard.includes.alerts.success')
                                @include('dashboard.includes.alerts.errors')
                                <div class="card-content collapse show">
                                    
                                    
                                    
                                    <div class="card-body">
                                        
                                          <div class="panel-body">
          <form id="dropzoneForm" class="dropzone" action="{{ route('slider.upload') }}" 
                method="POST"
                enctype="multipart/form-data">
            @csrf
                                         
                                           
          </form>
          <div align="center">
            <button type="button" class="btn btn-info" id="submit-all">Upload</button>
          </div>
        </div>
                                      

                                    </div>
                                </div>
                                
                                 
                            </div>
                            
                           
                             <div class="card">
                                <div class="card-content collapse show">
                                    <div class="row">
                                        
                                        @foreach ($images as $image)
    


                                        <div class="col-md-2" style="margin-bottom:16px;" align="center">
                                            <img src="{{$image->photo}}" class="img-thumbnail" width="175" height="175" style="height:175px;width:200px;" />
                                            <a href="{{route('slider.delete',$image -> id)}}"
                                               class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">حذف</a>

                                        </div>
                                        
                                        @endforeach
                                        

                                    </div>

                                 </div>
                            </div>
                            
                            
                            
                            
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>
            <br/>
            
        </div>
    </div>




 @stop
@section('script')
   <script type="text/javascript">

  Dropzone.options.dropzoneForm = {
    autoProcessQueue : false,
    acceptedFiles : ".png,.jpg,.gif,.bmp,.jpeg",

    init:function(){
      var submitButton = document.querySelector("#submit-all");
      myDropzone = this;

      submitButton.addEventListener('click', function(){
        myDropzone.processQueue();
      });

      this.on("complete", function(){
        if(this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0)
        {
          var _this = this;
          _this.removeAllFiles();
        }
        load_images();
      });

    }

  };

  //load_images();

  function load_images()
  {
    $.ajax({
      url:"{{ route('slider.fetch') }}",
      success:function(data)
      {
        $('#uploaded_image').html(data);
      }
    })
  }

 

</script>
@stop


