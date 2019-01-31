<template>
  <nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <ul class="nav flex-column">
          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span> <i class="fas fa-bars"></i> Menú</span>
        </h6>
          <li class="nav-item">
            <a class="nav-link" href="/#/buscar">
              <i class="fas fa-apple-alt"></i>
              Buscar producto
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/#/datos">
              <i class="far fa-chart-bar"></i>
              Datos
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Developers</span>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Información
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              API
            </a>
          </li>
        </ul>
      </div>
    </nav>
</template>
