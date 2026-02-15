<?php
use App\Http\Controllers\Helper;
?>
@extends('layouts-side-bar.master')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-p1B9XJvxXlJ0sFh1ExAmH4y3L1kGk+x+r6Gx7q6v5+PgfKhnYzOZ3xGlKEX2eVZCMu1k7r1R7pLLj5p2lP2vXw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@section('content')
    <div class="side-app">

        <div class="row">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card bg-primary">
                    <div class="card-header">
                        @include('layouts.iteb-grading-buttons')
                    </div>
                </div>
            </div>
        </div>
{{-- 
        <div class="row">
            <div class="col-lg-12">
                <div class="card bg-primary">
                    <div class="card-header">
                        <h4 class="text-white mb-0">Search Students</h4>
                    </div>
                    <div class="card-body bg-light">
                        <form id="studentSearchForm">
                            <div class="form-group mb-3">
                                <label for="search_criteria">Select Search Criteria</label>
                                <select id="search_criteria" class="form-control">
                                    <option value="" selected disabled>Select...</option>
                                    <option value="admission_number">Admission Number</option>
                                    <option value="phone">Phone Number</option>
                                </select>
                            </div>

                            <div id="search_inputs">
                                <!-- Dynamically populated fields here -->
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-success d-none" id="searchBtn">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Results -->
                <div class="card mt-4 d-none" id="resultsCard">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Search Results</h5>
                    </div>
                    <div class="card-body bg-white" id="searchResults">
                        <!-- Results will be rendered here -->
                    </div>
                </div>
            </div>
        </div> --}}

    </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  
@endsection

