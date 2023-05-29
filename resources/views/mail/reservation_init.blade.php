Salut, {{ $name }}
<br>
Votre reservation du {{$reservation->date_reservation}} a changé de status <span>{{$reservation->status}}</span>
<p>Montant ht: {{$reservation->totalht}}</p>
<p>Montant tva: {{$reservation->totaltva}}</p>
<p>Montant ttc: {{$reservation->total}}</p>
<p>Mode de paiement: {{$reservation->getPayement($reservation->type_paiement)}}</p>
<br>
<h5>Detail de la reservation</h5>
<table class="table table-bordered mt-2">
    <thead>
    <tr>
        <th>#</th>
        <th>Soin</th>
        <th>Prix</th>
        <th>Duree</th>
    </tr>

    </thead>
    <tbody>
    @foreach($prestations as $prestation)
        <tr>
            <td></td>
            <td>{{$prestation->soin->libelle}}</td>
            <td>{{$prestation->soin->price}}</td>
            <td>{{$prestation->soin->duree}}</td>
        </tr>
    @endforeach
    </tbody>
</table>



