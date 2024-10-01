@extends('layouts.template')

@section('content')
<section class="section dashboard">
     <div class="row col-12">

          <div class="col-6 col-md-3">
            <div class="card info-card customers-card home-card-height">
              <div class="card-body p-2">
               <h5 class="card-title text-dark">Classe</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fas fa-folder-open"> </i>
                  </div>
                  <div class="ps-3">
                  <h6>{{$classrooms}}</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-6 col-md-3">
            <div class="card info-card customers-card home-card-height">
              <div class="card-body p-2">
               <h5 class="card-title text-dark">Elèves</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fas fa-folder-open"> </i>
                  </div>
                  <div class="ps-3">
                  <h6>`{{ $students }}</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-6 col-md-3">
            <div class="card info-card customers-card home-card-height">
              <div class="card-body p-2">
               <h5 class="card-title text-dark">Administration</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fas fa-folder-open"> </i>
                  </div>
                  <div class="ps-3">
                  <h6>{{ $staff }}</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="card info-card customers-card home-card-height">
              <div class="card-body p-2">
               <h5 class="card-title text-dark">Matières</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fas fa-folder-open"> </i>
                  </div>
                  <div class="ps-3">
                  <h6>{{ $subjects }}</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
</section>
@endsection
