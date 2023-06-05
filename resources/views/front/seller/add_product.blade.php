@extends('front.base')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">{{$shop->libelle}}</a>
                    <span class="breadcrumb-item active">Ajouter un product</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
    @include("back._partials.errors-and-messages")
    <div class="container">
        <h4 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
            <span class="bg-secondary pr-3">Ajouter un produit</span></h4>
        <div class="card">
            <div class="card-body">
               {{-- <form method="POST" class="dropzone" action="{{route('seller_add_product')}}" enctype="multipart/form-data"
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

                            <input class="form-control"
                                   accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" name="image" type="file" id="name" required="" placeholder="Enter your name">
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label">Description</label>
                            <textarea class="form-control" name="description" type="text" id="name" required="" placeholder="Enter your name">
                                </textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
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
                    </div>

                    <div class="row mt-3 d-grid text-center">
                        <button class="btn btn-success" type="submit"> Enregistrer </button>
                    </div>
                </form>
                --}}
                <form method="POST" class="dropzone" action="{{route('seller_add_product')}}"
                      enctype="multipart/form-data"
                      data-plugin="dropzone" data-previews-container="#file-previews"
                      data-upload-preview-template="#uploadPreviewTemplate">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label">Libelle</label>
                            <input class="form-control" name="libelle" type="text" id="name" required=""
                                   placeholder="">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Prix</label>
                            <input class="form-control" min="0" name="price" type="text" id="name"
                                   required="" placeholder="">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Prix de vente</label>
                            <input class="form-control" min="0" name="price_sell" type="text" id="name"
                                   required="" placeholder="">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Quantite</label>
                            <input class="form-control" min="0" name="quantite" type="number" id="name"
                                   required="" placeholder="">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Categorie</label>
                            <select name="product_type_id" id="inputState" class="form-select">
                                <option value="" selected disabled>Choisir la categorie</option>
                                @foreach($categories as $item)
                                    <option value="{{$item->id}}">{{$item->libelle}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="virtual" class="form-label">Produit virtuel?</label>
                            <input id="virtual" class="form-check" name="virtual" type="checkbox"
                                   placeholder="">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="isdownloable" class="form-label">Produit téléchargeable?</label>
                            <input id="isdownloable" class="form-check" name="isdownloable" type="checkbox"
                            >
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label">Image</label>

                            <input class="form-control"
                                   accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*"
                                   name="image" type="file" id="name" required=""
                                   placeholder="">
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" rows="4" class="form-control" name="description" type="text"
                                      required="" placeholder="">
                                            </textarea>
                        </div>
                    </div>
                    <div id="contenu-virtual" class="row">
                        <div class="mb-3 col-md-12">
                            <label for="freeview" class="form-label">Contenu libre</label>
                            <textarea id="freeview" rows="4" class="form-control" name="freeview" type="text"
                                      placeholder="">
                                            </textarea>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="paidview" class="form-label">Contenu payant</label>
                            <textarea id="paidview" rows="4" class="form-control" name="paidview" type="text"
                                      placeholder="">
                                            </textarea>
                        </div>

                    </div>
                    <div id="contenu-downloable" class="row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Fichier</label>
                            <input class="form-control"
                                   name="downloable_file" type="file" id="file" required=""
                            >
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="downloable_day" class="form-label">Jours d'expiration</label>
                            <input class="form-control"
                                   name="downloable_day" type="number" id="downloable_day" min="0"
                            >
                        </div>
                    </div>
                    <div class="row mt-3 d-grid text-center">
                        <button class="btn btn-success" type="submit"> Enregistrer</button>
                    </div>
                </form>

            </div>
        </div>


    </div>

@endsection
