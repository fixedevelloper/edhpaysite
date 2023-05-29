@extends('back.base')

@section('content')
    <div class="content-page">
        <span id="item_id" hidden></span>
        <div class="content">
        @include("back._partials.errors-and-messages")
        <!-- Start Content-->
            <div class="container-fluid">
                <div class="row mt-3">

                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>Commandes</h3>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <div class="btn-group">
                                      {{--  <a href="{{route('facturation.create')}}" type="button" class="btn btn-primary btn-sm"><i class="mdi mdi-plus-circle"></i>Nouvelle facture
                                        </a>--}}

                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Table -->
                                <div class="table-responsive datatable-custom">
                                    <table
                                        class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>#N°</th>
                                            <th>Date</th>
                                            <th style="width: 30%">Client</th>
                                            <th>Montant Ht</th>
                                            <th>Tva</th>
                                            <th>Montant ttc</th>
                                           <th>Action</th>
                                        </tr>
                                        </thead>

                                        <tbody id="set-rows">
                                        @foreach($agents as $key=>$agent)
                                            <tr>
                                                <td>{{$agents->firstitem()+$key}}</td>
                                                <td>
                                                    {{$agent['created_at']}}
                                                </td>
                                                <td>
                                                    {{$agent['user']->name}}
                                                </td>
                                              {{--  <td>
                                                    @if($agent['typefacture']=="soins")
                                                   <span class="badge badge-soft-success">{{$agent['typefacture']}}</span>
                                                    @else
                                                        <span class="badge badge-soft-danger">{{$agent['typefacture']}}</span>
                                                    @endif
                                                </td>--}}
                                                <td>
                                                    {{$agent['montantht']}} FCFA
                                                </td>
                                                <td>
                                                    {{$agent['tva']}} FCFA
                                                </td>
                                                <td>
                                                    {{$agent['montantttc']}} FCFA
                                                </td>
                                                <td>
                                                    <a class="btn-sm btn-secondary p-1 pr-2 m-1"
                                                       href="{{route('order.edit',[$agent['id']])}}">
                                                        <i class="mdi mdi-eye pl-1" aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                                <!-- End Table -->
                            </div>
                            <!-- Footer -->
                            <div class="card-footer">
                                <!-- Pagination -->
                                <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                                    <div class="col-sm-auto">
                                        <div class="d-flex justify-content-center justify-content-sm-end">
                                            <!-- Pagination -->
                                            {!! $agents->links() !!}
                                            <nav id="datatablePagination" aria-label="Activity pagination"></nav>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Pagination -->
                            </div>
                            <!-- End Footer -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


