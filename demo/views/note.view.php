<?php require('components/head.php') ?>
<?php require('components/nav.php') ?>

<header class="bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <h1 class="text-3xl font-bold tracking-tight text-gray-900">About us</h1>
    </div>
  </header>

  <main>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
          <p>NOTES</p>

        <?php foreach ($notes as $note) : ?>
        
          <li>
          <a href="/demo/index.php?notes?id=<?= $note['id']?>" class="text-blue-500">
            <?=  $note['body'] ?>
          </a>
        </li>

        <?php  endforeach; ?>
    
    </div>
  </main>
  <?php require('components/footer.php') ?>