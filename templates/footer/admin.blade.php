@php
    $home = route('admin');
    $logo = '/assets/images/logos/lesprixbas_smaller.png';
@endphp

<footer class='py-5 border-top mt-auto bg-light'>
    <div class='container bigfooter'>
        <div class='container'>
            <div class='row'>
                <div class='col-12 col-md'>
                    <a href='{{ $home }}'>
                        <img class='mb-2' src='{{ $logo }}' alt='Cpascher' />
                    </a>
                    <small class='d-block mb-3 text-muted'>&copy; 2021</small>
                </div>
                <div class='col-6 col-md'>
                    <h5>Features</h5>
                    <ul class='list-unstyled text-small'>
                        <li>
                            <a class='text-muted' href='{{ $home }}'>
                                Cool stuff
                            </a>
                        </li>
                    </ul>
                </div>
                <div class='col-6 col-md'>
                    <h5>Resources</h5>
                    <ul class='list-unstyled text-small'>
                        <li>
                            <a class='text-muted' href='{{ $home }}'>
                                Resource
                            </a>
                        </li>
                    </ul>
                </div>
                <div class='col-6 col-md'>
                    <h5>About</h5>
                    <ul class='list-unstyled text-small'>
                        <li>
                            <a class='text-muted' href='{{ $home }}'>
                                Terms
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
