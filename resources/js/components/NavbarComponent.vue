<template>
    <header class="container justify-center-content">
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="/">Full Stack VueJS/Laravel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse">
          
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="/">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/posts">Posts</a>
            </li>
          </ul>

          <form id="form-login" class="form-inline my-2 my-lg-0" hidden>
            <input id="username" class="form-control mr-sm-2" type="text" placeholder="Username" aria-label="Username">
            <input id="password" class="form-control mr-sm-2" type="password" placeholder="Password" aria-label="Password">
            <button id="btn-login" class="btn btn-outline-info my-2 my-sm-0" type="submit">Login</button>
          </form>

        </div>

      </nav>
    </header>
</template>
