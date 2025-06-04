<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-6 mb-4">
        <?php
            $imgName = strtolower(str_replace(' ', '', $templateParams['vehicle'][0]['marca'] . $templateParams['vehicle'][0]['modello'])) . ".jpeg";
            $imgPath = "style/vehicleImgs/" . $imgName;
        ?>
              
        <img src="<?php echo $imgPath; ?>" class="card-img-top card-hover" alt="<?php echo strtolower(str_replace(' ', '', $templateParams['vehicle'][0]['marca'] . $templateParams['vehicle'][0]['modello'])) . ".jpeg"; ?>">

    </div>
    <div class="col-lg-6 text-light">
      <h2><?php echo htmlspecialchars($templateParams['vehicle'][0]['marca'] . " " . $templateParams['vehicle'][0]['modello']); ?></h2>
      <p><strong>Alimentazione:</strong> <?php echo htmlspecialchars($templateParams['vehicle'][0]['alimentazione']); ?></p>
      <p><strong>Kilometri:</strong> <?php echo number_format($templateParams['vehicle'][0]['kilometri']); ?></p>
      <p><strong>Descrizione:</strong> <?php echo htmlspecialchars($templateParams['vehicle'][0]['descrizione']); ?></p>
      <p><strong>Prezzo:</strong> € <?php echo number_format($templateParams['vehicle'][0]['prezzo'], 2); ?></p>
      <p><strong>Stato:</strong> 
        <span class="badge <?php echo $templateParams['vehicle'][0]['venduto'] ? 'bg-danger' : 'bg-success'; ?>">
          <?php echo $templateParams['vehicle'][0]['venduto'] ? 'Venduto' : 'Disponibile'; ?>
        </span>
      </p>
      <p><strong>Veicolo fornito da: </strong>
  <a href="dealerShowroom.php?partitaIva=<?php echo urlencode($templateParams['vehicle'][0]['concessionaria']); ?>" class="text-info text-decoration-underline">
    <?php echo htmlspecialchars($templateParams['vehicle'][0]['ragSociale']); ?>
  </a>
</p>
      
      <?php if (!$templateParams['vehicle'][0]['venduto']): ?>
    <?php if(isset($_SESSION['username'])): ?>
        <form action="addToCart.php" method="POST">
            <input type="hidden" name="telaio" value="<?php echo htmlspecialchars($templateParams['vehicle'][0]['numTelaio']); ?>">
            <button type="submit" class="btn btn-success mt-3">Aggiungi al carrello</button>
        </form>
    <?php else: ?>
        <button type="button" class="btn btn-secondary mt-3" disabled>Aggiungi al carrello</button>
        <p class="mt-2 text-warning">Effettua l’accesso per poter utilizzare il carrello.</p>
    <?php endif; ?>
<?php else: ?>
    <p class="text-warning mt-3">Questo veicolo non è disponibile.</p>
<?php endif; ?>
    </div>
  </div>
</div>
