@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Add Countries
                </h3>
                {!! Breadcrumbs::generate(['Dashboards', 'GEO', 'Create Countries'], 'metronic') !!}
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">

                <form action="{{url('admin/geo')}}" method="POST">

                    {{csrf_field()}}

                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="countries">Countries</label>
                            <textarea id="countries" class="form-control" name="countries" rows="5" required></textarea>
                            <span class="m-form__help">
                                Enter the name of the countries. Each country from a new line
                            </span>
                        </div>
                    </div>


                    <div class="row form-group">
                        <div class="col-md-6">
                            <button class="btn btn-success" type="submit">Save
                            </button>
                            <a href="{{url('admin/geo')}}" class="btn btn-danger" name="action">Cancel
                            </a>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection