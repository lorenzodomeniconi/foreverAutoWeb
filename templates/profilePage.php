<div class="container">
    <div class="profile-container">
        <br>
        <h2 class="text-light mb-4">Il tuo Profilo</h2>
        
        <?php if ($_SESSION["ruolo"] === "acquirente"): ?>
            <?php if (isset($templateParams["username"])): ?>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($templateParams["username"]); ?></p>
            <?php endif; ?>

            <?php if (isset($templateParams["nome"])): ?>
                <p><strong>Nome:</strong> <?php echo htmlspecialchars($templateParams["nome"]); ?></p>
            <?php endif; ?>
            
            <?php if (isset($templateParams["cognome"])): ?>
                <p><strong>Cognome:</strong> <?php echo htmlspecialchars($templateParams["cognome"]); ?></p>
            <?php endif; ?>
            
            <?php if (isset($templateParams["telefono"])): ?>
                <p><strong>Telefono:</strong> <?php echo htmlspecialchars($templateParams["telefono"]); ?></p>
            <?php endif; ?>    
            
            <?php if (isset($templateParams["email"])): ?>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($templateParams["email"]); ?></p>
            <?php endif; ?>
            <hr>

        <?php elseif ($_SESSION["ruolo"] === "concessionaria"): ?>
            <?php if (isset($templateParams["ragSociale"])): ?>
                <p><strong>Ragione Sociale:</strong> <?php echo htmlspecialchars($templateParams["ragSociale"]); ?></p>
            <?php endif; ?>
            
            <?php if (isset($templateParams["partitaIva"])): ?>
                <p><strong>Partita IVA:</strong> <?php echo htmlspecialchars($templateParams["partitaIva"]); ?></p>
            <?php endif; ?>

            <?php if (isset($templateParams["sede"])): ?>
                <p><strong>Sede:</strong> <?php echo htmlspecialchars($templateParams["sede"]); ?></p>
            <?php endif; ?>

            <?php if (isset($templateParams["telefono"])): ?>
                <p><strong>Telefono:</strong> <?php echo htmlspecialchars($templateParams["telefono"]); ?></p>
            <?php endif; ?>    

            <?php if (isset($templateParams["email"])): ?>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($templateParams["email"]); ?></p>
            <?php endif; ?>
        
            <hr>
            
            <a href="manage_vehicles.php" class="btn btn-primary">Gestisci Veicoli</a>
        <?php endif; ?>

        <hr>
        <a href="logout.php" class="btn btn-secondary mt-3">Logout</a>
    </div>
</div>