<footer class="pt-5 text-center mt-5">
    <nav class="footer-menu">
        <ul class="list-unstyled d-flex flex-column flex-sm-row justify-content-center gap-3 mb-2">
            <li><a href="{{ route('conditions') }}">Conditions Générales de Vente</a></li>
            <li><a href="{{ route('mentions') }}">Mentions Légales</a></li>
            <li><a href="{{ route('confidentialite') }}">Politique de Confidentialité</a></li>
        </ul>
    </nav>
    <div class="list-unstyled d-flex flex-row justify-content-center gap-3 mb-0">
        <a href="https://www.instagram.com/origine_savonnerie" target="blank">
            <img src="{{ asset('/images/instagram.png')}}" alt="Logo instagram" style="width:25px;">
        </a>
        <a href="https://www.facebook.com/profile.php?id=100092203184416" target="blank">
            <img src="{{ asset('/images/facebook.png')}}" alt="Logo facebook" style="width:25px">
        </a>
    </div>
    <p class="pt-4 text-center text-sm text-white">© 2024, Origine Savonnerie | Site réalisé par Romain Demay</p>
</footer>
