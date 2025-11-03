@extends('features.layouts.app')

@section('content')
    <div class="container">

        <div class="d-flex align-items-center justify-content-center mt-5">
            <!-- Add Button -->
            <button data-bs-toggle="modal" data-bs-target="#addFeatureModal" class="btn btn-primary">
                @if($features->count()) Edit Featured @else Add Featured @endif
            </button>
        </div>

        <div class="custom-success">
            @if (Session('success'))
                <p class="alert alert-success text-center">{{Session('success')}}</p>
            @endif
        </div>

        <!-- Slider Section -->
        <div class="features-main">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @foreach($features as $feature)
                        <div class="swiper-slide">
                            {{-- inner-slider-items apprach 1 --}}
                            {{-- <div class="card">
                                <div id="slider-{{ $feature->id }}" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach(json_decode($feature->photos) as $key => $photo)
                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                            <img src="{{ asset('uploads/features/' . $photo) }}">
                                        </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#slider-{{ $feature->id }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#slider-{{ $feature->id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                </div>
                                <div class="photo-count">
                                    +{{ $feature->photo_count }}
                                </div>
                                <div class="card-body">
                                    <p><strong>{{ $feature->feature_name }}</strong></p>
                                    <form action="{{ route('features.destroy', $feature->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                    </form>
                                </div>
                            </div> --}}

                            {{-- inner-slider-items apprach 2 --}}
                            <div class="card">
                                <div class="swiper feature-inner-slider" id="slider-{{ $feature->id }}">
                                    <div class="swiper-wrapper">
                                        @foreach(json_decode($feature->photos) as $photo)
                                        <div class="swiper-slide">
                                            <img src="{{ asset('uploads/features/' . $photo) }}" class="img-fluid" />
                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="photo-count">+{{ $feature->photo_count }}</div>

                                    <!-- Inner navigation -->
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                </div>

                                <div class="card-body">
                                    <p><strong>{{ $feature->feature_name }}</strong></p>
                                    <form action="{{ route('features.destroy', $feature->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Optional pagination and navigation buttons -->
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="addFeatureModal">
            <div class="modal-dialog">
                <form action="{{ route('features.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Featured</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="mb-1">Feature Name</label>
                    <input type="text" name="feature_name" class="form-control mb-2" value="{{ old('feature_name') }}">
                    @error('feature_name')
                        <p class="text text-danger">{{$message}}</p>
                    @enderror
                    <label class="mt-2 mb-1">Photos (multiple)</label>
                    <input type="file" name="photos[]" multiple class="form-control">
                    {{-- Main input error --}}
                    @error('photos')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    {{-- Each photo error --}}
                    @if ($errors->has('photos.*'))
                        @foreach ($errors->get('photos.*') as $photoErrors)
                            @foreach ($photoErrors as $error)
                                <p class="text-danger">{{ $error }}</p>
                            @endforeach
                        @endforeach
                    @endif
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
                </form>
            </div>
        </div>

    </div>



{{-- Modal show if something is error --}}

@if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var modalEl = document.getElementById('addFeatureModal');
            if (modalEl) {
                var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            }
        });
    </script>
@endif



@endsection
