<div class="col-6 mb-4">
    <div class="card">
        <img class="card-img-top" height="200"  width="80" src= "https://static.lematin.ma/files/lematin/images/articles/2020/09/81529c2ddbfe883cea4858f4d6353e37.jpg">
        <div class="card-body">
            <h5>Afficher les cours dont je suis reponsable</h5>
            <a class="stretched-link" href="{{route('cours_enseignant_index')}}"></a>
        </div>
    </div>
</div>

<div class="col-6 mb-4">
    <div class="card">
        <img class="card-img-top" height="200"  width="80" src= "https://www.lemondedesartisans.fr/sites/lemondedesartisans.fr/files/styles/large/public/illustrations/articles/organisation-du-travail.jpg?itok=6jMll1MF">
        <div class="card-body">
            <h5>Voir mon planning</h5>
            <a class="stretched-link" href="{{Route('planning_index', ['userId'=> Auth::user()->id])}}"></a>
        </div>
    </div>
</div>
