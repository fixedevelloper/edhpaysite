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
                                <h3>Produits</h3>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <div class="btn-group">
                                        <a type="button" class="btn btn-primary btn-sm" href="{{route('product.create')}}"><i class="mdi mdi-plus-circle"></i>Ajouter un produit
                                        </a>

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
                                           <th style="width: 15%">image</th>
                                            <th style="width: 30%">Categorie</th>
                                            <th>libelle</th>
                                            <th>Quantite</th>
                                            <th>Prix</th>
                                            <th>Prix de vente</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>

                                        <tbody id="set-rows">
                                        @foreach($agents as $key=>$agent)
                                            <tr>
                                                <td>{{$agents->firstitem()+$key}}</td>
                                               <td>
                                                    <img class="rounded-circle" height="60px" width="60px" style="cursor: pointer"
                                                         onclick="location.href='{{route('product.edit',[$agent['id']])}}'"

                                                         src="{{asset('storage/images')}}/{{$agent['images'][0]->src}}">
                                                </td>
                                                <td>
                                                    @if($agent['categorie'])
                                                    {{$agent['categorie']->libelle}}
                                                    @else
                                                        {{$agent['categorie']}}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{$agent['libelle']}}
                                                </td>
                                                <td>
                                                    {{$agent['quantity']}}
                                                </td>
                                                <td>
                                                    {{$agent['price']}} FCFA
                                                </td>
                                                <td>
                                                    {{$agent['sale_price']}} FCFA
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                    <a class="btn btn-sm btn-secondary"
                                                       href="{{route('product.edit',[$agent['id']])}}">
                                                        <i class="mdi mdi-pencil pl-1" aria-hidden="true"></i>
                                                    </a>
                                                    <a class="btn btn-sm btn-danger" onclick="getItem({{$agent['id']}})"
                                                       data-bs-toggle="modal" data-bs-target="#bs-delete-modal-sm">
                                                        <i class="mdi mdi-trash-can pl-1" aria-hidden="true"></i>
                                                    </a></div>
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
    <div class="modal fade" id="bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mySmallModalLabel">Ajouter un produit</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" class="dropzone" action="{{route('product.store')}}" enctype="multipart/form-data"
                          data-plugin="dropzone" data-previews-container="#file-previews"
                          data-upload-preview-template="#uploadPreviewTemplate">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="name" class="form-label">Libelle</label>
                                <input class="form-control" name="libelle" type="text" id="name" required="" placeholder="Enter your name">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">Prix</label>
                                <input class="form-control" min="0" name="price" type="text" id="name" required="" placeholder="Enter your name">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">Prix de vente</label>
                                <input class="form-control" min="0" name="price_sell" type="text" id="name" required="" placeholder="Enter your name">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">Quantite</label>
                                <input class="form-control" min="0" name="quantite" type="number" id="name" required="" placeholder="Enter your name">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">Categorie</label>
                                <select name="product_type_id" id="inputState" class="form-select">
                                    <option value=""  selected disabled>Choisir la categorie</option>
                                    @foreach($categories as $item)
                                        <option value="{{$item->id}}">{{$item->libelle}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="name" class="form-label">Image</label>

                                <input class="form-control" multiple
                                       accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" name="image" type="file" id="name" required="" placeholder="Enter your name">
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="name" class="form-label">Description</label>
                                <textarea class="form-control" name="description" type="text" id="name" required="" placeholder="Enter your name">
                                </textarea>
                            </div>
                        </div>
                        <!-- Preview -->
                        <div class="dropzone-previews mt-3" id="file-previews"></div>
                        <!-- file preview template -->
                        <div class="d-none" id="uploadPreviewTemplate">
                            <div class="card mt-1 mb-0 shadow-none border">
                                <div class="p-2">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <img data-dz-thumbnail src="#" class="avatar-sm rounded bg-light" alt="">
                                        </div>
                                        <div class="col ps-0">
                                            <a href="javascript:void(0);" class="text-muted fw-bold" data-dz-name></a>
                                            <p class="mb-0" data-dz-size></p>
                                        </div>
                                        <div class="col-auto">
                                            <!-- Button -->
                                            <a href="" class="btn btn-link btn-lg text-muted" data-dz-remove>
                                                <i class="dripicons-cross"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 d-grid text-center">
                            <button class="btn btn-success" type="submit"> Enregistrer </button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade" id="bs-delete-modal-sm" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mySmallModalLabel">Supprimer le product</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Cette action est irreverssible</p>
                    <form>
                        {{csrf_field()}}

                        <div class="mb-3 d-grid text-center">
                            <button class="btn btn-danger" type="button" id="delete_btn_product"> Supprimer </button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection


