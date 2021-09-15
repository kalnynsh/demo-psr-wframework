<?php
/** @var \Framework\Template\Php\TemplateRenderer $this */
?>

<?php $this->extend('layout/columns'); ?>

<?php $this->blockBegin('title'); ?>
    Cabinet
<?php $this->blockEnd(); ?>

<?php $this->blockBegin('meta'); ?>

    <meta
        name="description"
        content="User's cabinet page"
    />

<?php $this->blockEnd(); ?>

<?php $this->blockBegin('topNavbar'); ?>

    <div class="container">
        <header
            class="d-flex flex-wrap align-items-center justify-content-center
                justify-content-md-between py-3 mb-4 border-bottom">

            <a
                href="/"
                class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 64 64" width="64px" height="64px">
                    <linearGradient id="Yz6f8FIFqMLeHS3CJHqXla" x1="32.5" x2="32.5" y1="7" y2="59" gradientUnits="userSpaceOnUse" spreadMethod="reflect">
                        <stop offset="0" stop-color="#1a6dff"/><stop offset="1" stop-color="#c822ff"/>
                        </linearGradient>
                    <path fill="url(#Yz6f8FIFqMLeHS3CJHqXla)" d="M43.975,39.27c0.009-0.063,0.016-0.124,0.013-0.188c-0.004-0.07-0.02-0.135-0.039-0.203 c-0.011-0.04-0.007-0.081-0.023-0.121c-0.008-0.019-0.024-0.031-0.033-0.049c-0.029-0.06-0.069-0.112-0.11-0.166 c-0.041-0.055-0.08-0.108-0.131-0.152c-0.015-0.013-0.022-0.032-0.038-0.044c-0.033-0.026-0.073-0.033-0.109-0.054 c-0.061-0.037-0.12-0.071-0.188-0.094c-0.06-0.02-0.118-0.029-0.179-0.037c-0.065-0.009-0.128-0.017-0.195-0.013 c-0.068,0.004-0.131,0.02-0.197,0.038c-0.042,0.011-0.084,0.007-0.125,0.024C39.796,39.364,36.051,40,32.075,40 c-3.76,0-7.355-0.577-10.125-1.625c-0.512-0.194-1.093,0.064-1.289,0.582c-0.068,0.179-0.064,0.361-0.03,0.536 c-0.058,0.288-0.004,0.595,0.2,0.837C23.905,43.986,27.898,46,32.075,46c4.419,0,8.579-2.22,11.714-6.25 c0.027-0.034,0.034-0.075,0.055-0.111c0.036-0.06,0.069-0.118,0.092-0.184C43.957,39.393,43.966,39.333,43.975,39.27z M24.58,41.217 C26.881,41.725,29.443,42,32.075,42c2.629,0,5.174-0.267,7.459-0.768C37.291,43.023,34.733,44,32.075,44 C29.42,44,26.836,43.025,24.58,41.217z M27.204,27.993c1.387-0.592,3.161-0.917,4.996-0.917c1.943,0,3.797,0.361,5.219,1.016 c0.501,0.231,0.721,0.825,0.489,1.327C37.739,29.785,37.378,30,36.999,30c-0.14,0-0.282-0.029-0.418-0.092 c-1.164-0.537-2.72-0.833-4.381-0.833c-1.571,0-3.066,0.269-4.211,0.757c-0.505,0.215-1.096-0.019-1.313-0.527 C26.46,28.798,26.696,28.21,27.204,27.993z M42,31c0,1.072-0.317,1.896-0.943,2.447c-1.049,0.923-2.536,0.73-3.521,0.607 c-0.063-0.008-0.125-0.017-0.184-0.023C36.162,35.031,34.117,36,32,36s-4.162-0.969-5.353-1.969 c-0.059,0.007-0.12,0.016-0.184,0.023c-0.984,0.124-2.472,0.315-3.521-0.607C22.317,32.896,22,32.072,22,31c0-0.552,0.447-1,1-1 s1,0.448,1,1c0,0.325,0.046,0.753,0.266,0.946c0.367,0.325,1.355,0.2,1.945,0.124C26.523,32.031,26.797,32,27,32h0.414l0.293,0.293 C28.556,33.142,30.303,34,32,34s3.444-0.858,4.293-1.707L36.586,32H37c0.203,0,0.477,0.031,0.789,0.07 c0.589,0.076,1.575,0.201,1.945-0.124C39.954,31.753,40,31.325,40,31c0-0.552,0.447-1,1-1S42,30.448,42,31z M21.29,18.699 c-0.386-0.391-0.386-1.018,0.003-1.406c1.249-1.25,4.594-2.877,8.307-0.093c0.442,0.331,0.532,0.958,0.2,1.4 c-0.196,0.262-0.496,0.4-0.801,0.4c-0.209,0-0.419-0.065-0.599-0.2c-3.177-2.38-5.45-0.33-5.698-0.088 C22.307,19.096,21.676,19.089,21.29,18.699z M34.29,18.699c-0.386-0.391-0.386-1.018,0.003-1.406 c1.249-1.25,4.594-2.877,8.307-0.093c0.442,0.331,0.532,0.958,0.2,1.4c-0.196,0.262-0.496,0.4-0.801,0.4 c-0.209,0-0.419-0.065-0.599-0.2c-3.176-2.38-5.449-0.33-5.698-0.088C35.306,19.096,34.675,19.089,34.29,18.699z M19.895,33.447 c-0.043,0.086-0.992,1.951-2.895,3.137V40c0,0.553-0.447,1-1,1s-1-0.447-1-1v-4c0-0.379,0.214-0.725,0.553-0.895 c1.655-0.828,2.544-2.536,2.553-2.553c0.247-0.494,0.848-0.692,1.342-0.447C19.941,32.353,20.142,32.953,19.895,33.447z M48.447,35.105C48.786,35.275,49,35.621,49,36v4c0,0.553-0.447,1-1,1s-1-0.447-1-1v-3.416c-1.902-1.186-2.852-3.051-2.895-3.137 c-0.247-0.494-0.047-1.095,0.447-1.342c0.493-0.244,1.094-0.048,1.341,0.445C45.917,32.596,46.799,34.281,48.447,35.105z M56,8 c-1.437,0-2.668,0.998-3.372,2.522c-0.095,0.154-0.195,0.31-0.289,0.463c-0.98,1.609-1.905,3.129-4.243,4.925l-0.789,0.606 C44.55,11.959,39.764,7,32,7c-5.849,0-10.977,3.132-14.886,9.072l-0.211-0.162c-2.338-1.796-3.263-3.316-4.243-4.925 c-0.093-0.153-0.194-0.309-0.289-0.463C11.668,8.998,10.437,8,9,8c-2.243,0-4,2.416-4,5.5S6.757,19,9,19 c0.109,0,0.211-0.032,0.318-0.043c1.679,0.076,2.216,0.394,3.929,1.711l1.022,0.786c-0.23,0.542-0.46,1.068-0.685,1.585 C11.661,27.456,10,31.271,10,39.037C10,49.485,20.486,59,32,59s22-9.515,22-19.963c0-6.723-2.009-11.966-4.044-16.988l1.797-1.381 c1.713-1.317,2.25-1.635,3.929-1.711C55.789,18.968,55.891,19,56,19c2.243,0,4-2.416,4-5.5S58.243,8,56,8z M9,10 c0.404,0,0.822,0.274,1.175,0.734c0.019,0.041,0.024,0.086,0.05,0.125c0.139,0.213,0.263,0.42,0.393,0.63 C10.852,12.043,11,12.728,11,13.5c0,1.898-0.892,3.251-1.771,3.458c-0.184-0.007-0.36-0.017-0.563-0.019 C7.822,16.651,7,15.321,7,13.5C7,11.438,8.054,10,9,10z M50.534,19.082l-2.4,1.845c-0.356,0.274-0.486,0.753-0.317,1.169 C49.873,27.157,52,32.391,52,39.037C52,48.438,42.468,57,32,57s-20-8.562-20-17.963c0-7.35,1.509-10.814,3.419-15.2 c0.325-0.747,0.659-1.514,0.995-2.323c0.173-0.418,0.045-0.9-0.314-1.176l-1.634-1.256c-1.069-0.821-1.82-1.341-2.635-1.664 c0.51-0.696,0.87-1.591,1.045-2.596c0.702,0.847,1.581,1.73,2.809,2.674l1.08,0.83c0.226,0.174,0.518,0.242,0.793,0.19 c0.279-0.052,0.523-0.221,0.671-0.464C21.875,12.045,26.509,9,32,9c7.363,0,11.752,5.159,14.137,9.487 c0.141,0.255,0.386,0.437,0.672,0.497c0.067,0.014,0.136,0.021,0.204,0.021c0.219,0,0.434-0.072,0.609-0.207l1.693-1.302 c1.228-0.944,2.107-1.827,2.809-2.674c0.175,1.005,0.535,1.899,1.045,2.596C52.354,17.741,51.603,18.261,50.534,19.082z M56.334,16.938c-0.203,0.003-0.379,0.012-0.563,0.019C54.892,16.751,54,15.398,54,13.5c0-0.772,0.148-1.457,0.383-2.011 c0.13-0.209,0.254-0.417,0.393-0.63c0.026-0.039,0.03-0.084,0.05-0.125C55.178,10.274,55.596,10,56,10c0.946,0,2,1.438,2,3.5 C58,15.321,57.178,16.651,56.334,16.938z"/><linearGradient id="Yz6f8FIFqMLeHS3CJHqXlb" x1="32" x2="32" y1="10.875" y2="60.715" gradientUnits="userSpaceOnUse" spreadMethod="reflect"><stop offset="0" stop-color="#6dc7ff"/><stop offset="1" stop-color="#e6abff"/></linearGradient><path fill="url(#Yz6f8FIFqMLeHS3CJHqXlb)" d="M24.5,26c-1.381,0-2.5-1.119-2.5-2.5s1.119-2.5,2.5-2.5s2.5,1.119,2.5,2.5S25.881,26,24.5,26z M39.5,21c-1.381,0-2.5,1.119-2.5,2.5s1.119,2.5,2.5,2.5s2.5-1.119,2.5-2.5S40.881,21,39.5,21z M32,48c-3.588,0-6.677,1.637-8.122,4 h16.245C38.677,49.637,35.588,48,32,48z"/>
                    </svg>
            </a>

            <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                <li><a href="<?= $this->encode($this->path('home')) ?>" class="nav-link px-2 link-secondary ">Home</a></li>
                <li><a href="<?= $this->encode($this->path('cabinet')) ?>" class="nav-link px-2 link-dark active">Cabinet</a></li>
                <li><a href="<?= $this->encode($this->path('blog')) ?>" class="nav-link px-2 link-secondary">Blog</a></li>
                <li><a href="<?= $this->encode($this->path('about')) ?>" class="nav-link px-2 link-secondary">About</a></li>
            </ul>

            <div class="col-md-3 text-end">
            <button type="button" class="btn btn-outline-primary me-2">Login</button>
            <button type="button" class="btn btn-primary">Sign-up</button>
            </div>
        </header>
    </div>

<?php $this->blockEnd(); ?>

<?php $this->blockBegin('leftSidebar'); ?>

  <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                  <li class="nav-item">
                          <a class="nav-link" aria-current="page" href="/">
                              <svg xmlns="http://www.w3.org/2000/svg"
                                  width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                  stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home" aria-hidden="true">
                                  <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                  <polyline points="9 22 9 12 15 12 15 22"></polyline>
                              </svg>
                              Home
                          </a>
                      </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">
                            <svg
                              fill="#000000"
                              xmlns="http://www.w3.org/2000/svg"
                              viewBox="0 0 64 64"
                              width="24px"
                              height="24px"
                              fill="none"
                              stroke="currentColor"
                            >
                              <path d="M 7 10.058594 C 5.347656 10.058594 4 11.402344 4 13.058594 L 4 19.058594 C 4 19.859375 4.3125 20.613281 4.878906 21.179688 C 5.199219 21.5 5.582031 21.742188 6 21.890625 L 6 53.058594 C 6 54.710938 7.347656 56.058594 9 56.058594 L 57 56.058594 C 58.652344 56.058594 60 54.710938 60 53.058594 L 60 21.890625 C 60.417969 21.742188 60.800781 21.5 61.121094 21.179688 C 61.6875 20.613281 62 19.859375 62 19.058594 L 62 13.058594 C 62 11.402344 60.652344 10.058594 59 10.058594 Z M 7 12.058594 L 59 12.058594 C 59.550781 12.058594 60 12.503906 60 13.058594 L 60 19.058594 C 60 19.324219 59.894531 19.578125 59.707031 19.765625 C 59.519531 19.953125 59.269531 20.058594 59 20.058594 L 55 20.058594 C 54.449219 20.058594 54 20.503906 54 21.058594 C 54 21.609375 54.449219 22.058594 55 22.058594 L 58 22.058594 L 58 53.058594 C 58 53.609375 57.550781 54.058594 57 54.058594 L 9 54.058594 C 8.449219 54.058594 8 53.609375 8 53.058594 L 8 22.058594 L 43 22.058594 C 43.550781 22.058594 44 21.609375 44 21.058594 C 44 20.503906 43.550781 20.058594 43 20.058594 L 7 20.058594 C 6.730469 20.058594 6.480469 19.953125 6.292969 19.765625 C 6.105469 19.578125 6 19.324219 6 19.058594 L 6 13.058594 C 6 12.503906 6.449219 12.058594 7 12.058594 Z M 47 20.058594 C 46.449219 20.058594 46 20.503906 46 21.058594 C 46 21.609375 46.449219 22.058594 47 22.058594 L 51 22.058594 C 51.550781 22.058594 52 21.609375 52 21.058594 C 52 20.503906 51.550781 20.058594 51 20.058594 Z M 26 26 C 23.792969 26 22 27.792969 22 30 C 22 32.207031 23.792969 34 26 34 L 40 34 C 42.207031 34 44 32.207031 44 30 C 44 27.792969 42.207031 26 40 26 Z M 26 28 L 40 28 C 41.101563 28 42 28.898438 42 30 C 42 31.101563 41.101563 32 40 32 L 26 32 C 24.898438 32 24 31.101563 24 30 C 24 28.898438 24.898438 28 26 28 Z M 13 48.058594 C 12.449219 48.058594 12 48.503906 12 49.058594 L 12 51.058594 C 12 51.609375 12.449219 52.058594 13 52.058594 C 13.550781 52.058594 14 51.609375 14 51.058594 L 14 49.058594 C 14 48.503906 13.550781 48.058594 13 48.058594 Z M 18 48.058594 C 17.449219 48.058594 17 48.503906 17 49.058594 L 17 51.058594 C 17 51.609375 17.449219 52.058594 18 52.058594 C 18.550781 52.058594 19 51.609375 19 51.058594 L 19 49.058594 C 19 48.503906 18.550781 48.058594 18 48.058594 Z M 23 48.058594 C 22.449219 48.058594 22 48.503906 22 49.058594 L 22 51.058594 C 22 51.609375 22.449219 52.058594 23 52.058594 C 23.550781 52.058594 24 51.609375 24 51.058594 L 24 49.058594 C 24 48.503906 23.550781 48.058594 23 48.058594 Z M 28 48.058594 C 27.449219 48.058594 27 48.503906 27 49.058594 L 27 51.058594 C 27 51.609375 27.449219 52.058594 28 52.058594 C 28.550781 52.058594 29 51.609375 29 51.058594 L 29 49.058594 C 29 48.503906 28.550781 48.058594 28 48.058594 Z M 33 48.058594 C 32.449219 48.058594 32 48.503906 32 49.058594 L 32 51.058594 C 32 51.609375 32.449219 52.058594 33 52.058594 C 33.550781 52.058594 34 51.609375 34 51.058594 L 34 49.058594 C 34 48.503906 33.550781 48.058594 33 48.058594 Z M 38 48.058594 C 37.449219 48.058594 37 48.503906 37 49.058594 L 37 51.058594 C 37 51.609375 37.449219 52.058594 38 52.058594 C 38.550781 52.058594 39 51.609375 39 51.058594 L 39 49.058594 C 39 48.503906 38.550781 48.058594 38 48.058594 Z M 43 48.058594 C 42.449219 48.058594 42 48.503906 42 49.058594 L 42 51.058594 C 42 51.609375 42.449219 52.058594 43 52.058594 C 43.550781 52.058594 44 51.609375 44 51.058594 L 44 49.058594 C 44 48.503906 43.550781 48.058594 43 48.058594 Z M 48 48.058594 C 47.449219 48.058594 47 48.503906 47 49.058594 L 47 51.058594 C 47 51.609375 47.449219 52.058594 48 52.058594 C 48.550781 52.058594 49 51.609375 49 51.058594 L 49 49.058594 C 49 48.503906 48.550781 48.058594 48 48.058594 Z M 53 48.058594 C 52.449219 48.058594 52 48.503906 52 49.058594 L 52 51.058594 C 52 51.609375 52.449219 52.058594 53 52.058594 C 53.550781 52.058594 54 51.609375 54 51.058594 L 54 49.058594 C 54 48.503906 53.550781 48.058594 53 48.058594 Z"/></svg>
                            Cabinet
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-file" aria-hidden="true">
                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                            <polyline points="13 2 13 9 20 9"></polyline>
                    </svg>
                            Notes
                        </a>
                    </li>
                </ul>
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Data</span>
                    <a class="link-secondary" href="#" aria-label="Add a new report">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-plus-circle" aria-hidden="true">
                            <circle cx="12" cy="12" r="10">
                            </circle>
                            <line x1="12" y1="8" x2="12" y2="16"></line>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                    </a>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-file-text" aria-hidden="true">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13">
                            </line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        Current month
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

<?php $this->blockEnd(); ?>

<?php $this->blockBegin('description'); ?>

    <div class="col-lg-8 mx-auto p-3 py-md-5">
        <h1>Cabinet</h1>
        <p class="fs-5">
            Hello, <?= $this->encode($username); ?>!
        </p>
    </div>

<?php $this->blockEnd(); ?>
