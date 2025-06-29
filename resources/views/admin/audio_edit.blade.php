@extends('admin.layouts.master')

@section('content')
<div class="page-wrapper">
<!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Audio Files Management</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Audio Files
                    </li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
          <!-- ============================================================== -->
          <!-- Start Page Content -->
          <!-- ============================================================== -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{ url('/admin/updateaudio',$editaudio->id) }}">
                  @csrf
                  <div class="card-body">
                   <!--  <h4 class="card-title">Add Introductory</h4> -->
                    <div class="form-group row">
                      <label
                        for="title"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Audio Name</label
                      >
                      <div class="col-sm-5">
                        <input name="audio_name" value="{{ ($editaudio) ? (old('audio_name')? old('audio_name') : $editaudio->audio_name) : old('audio_name') }}"
                          type="text"
                          class="form-control @error('audio_name') is-invalid @enderror"
                          id="audio_name"
                          placeholder="Enter Your Audio Name"
                        />
                        @error('audio_name')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                        <label for="time" class="col-sm-2 text-end control-label col-form-label">Audio Type</label>
                        <div class="col-sm-5">
                          <select class="form-control" name="audio_type" id="audio_type">
                            <option {{($editaudio['audio_type'] == '' || $editaudio['audio_type'] == null )   ? 'Selected' : ''}}>Select Audio Type</option>
                              <option value="1" {{($editaudio['audio_type'] == '1')   ? 'Selected' : ''}}>1</option>
                              <option value="2" {{($editaudio['audio_type'] == '2')   ? 'Selected' : ''}}>2</option>
                              <option value="3" {{($editaudio['audio_type'] == '3')   ? 'Selected' : ''}}>3</option>
                              <option value="4" {{($editaudio['audio_type'] == '4')   ? 'Selected' : ''}}>4</option>
                              <option value="5" {{($editaudio['audio_type'] == '5')   ? 'Selected' : ''}}>5</option>
                          </select>
                          @error('audio_type')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="time" class="col-sm-2 text-end control-label col-form-label">Block</label>
                        <div class="col-sm-5">
                          <select class="form-control" name="block" id="block">
                            <option {{($editaudio['block'] == '' || $editaudio['block'] == null )   ? 'Selected' : ''}}>Select Block</option>
                              <option value="1" {{($editaudio['block'] == '1')   ? 'Selected' : ''}}>1</option>
                              <option value="2" {{($editaudio['block'] == '2')   ? 'Selected' : ''}}>2</option>
                              <option value="3" {{($editaudio['block'] == '3')   ? 'Selected' : ''}}>3</option>
                              <option value="4" {{($editaudio['block'] == '4')   ? 'Selected' : ''}}>4</option>
                              <option value="5" {{($editaudio['block'] == '5')   ? 'Selected' : ''}}>5</option>
                          </select>
                          @error('block')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="title"
                          class="col-sm-2 text-end control-label col-form-label"
                          >From Action Count:</label
                        >
                        <div class="col-sm-5">
                          <input name="factcount" value="{{ ($editaudio) ? (old('factcount')? old('factcount') : $editaudio->factcount) : old('factcount') }}"
                            type="text"
                            class="form-control @error('factcount') is-invalid @enderror"
                            id="factcount"
                            placeholder="From count"
                          />
                          @error('factcount')
                            <span class="invalid-feedback">{{$message }}</span>
                          @enderror
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="title"
                          class="col-sm-2 text-end control-label col-form-label"
                          >To Action Count:</label
                        >
                        <div class="col-sm-5">
                          <input name="tactcount" value="{{ ($editaudio) ? (old('tactcount')? old('tactcount') : $editaudio->tactcount) : old('tactcount') }}"
                            type="text"
                            class="form-control @error('tactcount') is-invalid @enderror"
                            id="tactcount"
                            placeholder="To count"
                          />
                          @error('tactcount')
                            <span class="invalid-feedback">{{$message }}</span>
                          @enderror
                        </div>
                      </div>
                       <div class="form-group row">
                      <label
                        for="audio_file"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Audio File</label
                      >
                      <div class="col-sm-5">
                        <input name="audio_file" value="{{old('audio_file')}}"
                          type="file"
                          class="form-control @error('audio_file') is-invalid @enderror"
                          id="audio_file"
                          placeholder="Enter Your Link"
                        />
                        @error('audio_file')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-5">
                        <audio controls>
                            <source src="{{asset('assets/images/audio/'.$editaudio->audio_file)}}" type="audio/mpeg"> 
                            </audio>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label
                          for="status"
                          class="col-sm-2 text-end control-label col-form-label"
                          >Status</label
                        >
                        <div class="col-sm-5">
                            <label class="switch">
                          
                                <input type="checkbox" name="audio_status" class="form-control status" id="audio_status"value="1" {{($editaudio['audio_status'] == 1)   ? 'checked' : ''}}>
                                                            
                                <span class="slider round"></span>
                            </label>
                        </div>
                      </div>

               
                  </div>
                  <div class="border-top">
                    <div class="card-body">
                      <button type="submit" class="btn btn-primary">
                        Submit
                      </button>
                    </div>
                  </div>
                </form>
              </div>
              </div>
            </div> 
          </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
         </div>
   
@endsection