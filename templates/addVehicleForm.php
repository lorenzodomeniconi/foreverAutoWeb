<div class="container my-5">
    <h2 class="text-light mb-4">Aggiungi un Nuovo Veicolo</h2>
    <form action="veicoloAggiunto.php" method="POST">
        <div class="mb-3">
            <label class="form-label text-light">Numero di Telaio</label>
            <input type="text" class="form-control dark-input" name="numTelaio" required>
        </div>
        <div class="mb-3">
            <label class="form-label text-light">Marca</label>
            <input type="text" class="form-control dark-input" name="marca" required>
        </div>
        <div class="mb-3">
            <label class="form-label text-light">Modello</label>
            <input type="text" class="form-control dark-input" name="modello" required>
        </div>
        <div class="mb-3">
            <label class="form-label text-light">Descrizione</label>
            <textarea class="form-control dark-input" name="descrizione" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label text-light">Alimentazione</label>
            <input type="text" class="form-control dark-input" name="alimentazione" required>
        </div>
        <div class="mb-3">
            <label class="form-label text-light">Prezzo (€)</label>
            <input type="number" class="form-control dark-input" name="prezzo" step="0.01" required>
        </div>
        <div class="mb-3">
            <label class="form-label text-light">Categoria</label><br>
            <select class="form-select dark-input" name="tipo" required>
                <option value="" disabled selected>Seleziona una categoria</option>
                <?php foreach ($templateParams["categories"] as $category): ?>
                    <option value="<?php echo $category["tipo"]; ?>"><?php echo htmlspecialchars($category["tipo"]); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label text-light">Kilometri</label>
            <input type="number" class="form-control dark-input" name="kilometri" required>
        </div>
        <div class="mb-3">
            <label class="form-label text-light">Proprietari Precedenti</label>
            <input type="number" class="form-control dark-input" name="proprietariPrecedenti" required>
        </div>
        <div class="text-end">
            <button type="submit" class="btn btn-success">Aggiungi Veicolo</button>
        </div>
    </form>
</div>
