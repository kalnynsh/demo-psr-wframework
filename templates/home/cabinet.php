<?php
/** @var \Framework\Template\TemplateRenderer $this */
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
                <span class="px-3">Logo</span>
            </a>

            <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                <li><a href="/" class="nav-link px-2 link-secondary">Home</a></li>
                <li><a href="/cabinet" class="nav-link px-2 link-dark active">Cabinet</a></li>
                <li><a href="#" class="nav-link px-2 link-secondary">Pricing</a></li>
                <li><a href="#" class="nav-link px-2 link-secondary">FAQs</a></li>
                <li><a href="/about" class="nav-link px-2 link-secondary">About</a></li>
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

<h1>Cabinet</h1>
<p class="fs-5">
    Hello, <?= htmlspecialchars($username, ENT_QUOTES | ENT_SUBSTITUTE) ?>!
</p>
