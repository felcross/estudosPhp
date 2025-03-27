<?php

namespace Model;


echo  <<<HTML
 
<form>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Email address</label>
      <input type="email" class="form-control" id="a" felipe="nome" aria-describedby="emailHelp">
      <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>

    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">Password</label>
      <input type="password" class="form-control" id="b" felipe="senha">
    </div>

    <div class="mb-3 form-check">
      <input type="checkbox" class="form-check-input" id="exampleCheck1">
      <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div>
    
    <button type="submit" acao="salvar" class="btn btn-primary">Submit</button>
  </form>

  <script type="module" src="/project/Public/js/teste.js" defer></script>

  
HTML;