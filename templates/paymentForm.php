<div class="container my-5 text-light">
    <h2>Inserisci i dati per la spedizione</h2>
    <form action="confirmPayment.php" method="POST" class="mt-4">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control dark-input" required>
        </div>
        <div class="mb-3">
            <label for="cognome" class="form-label">Cognome</label>
            <input type="text" name="cognome" id="cognome" class="form-control dark-input" required>
        </div>
        <div class="mb-3">
            <label for="indirizzo" class="form-label">Indirizzo</label>
            <input type="text" name="indirizzo" id="indirizzo" class="form-control dark-input" required>
        </div>
        <div class="mb-3">
            <label for="citta" class="form-label">Città</label>
            <input type="text" name="citta" id="citta" class="form-control dark-input" required>
        </div>
        <div class="mb-3">
            <label for="cap" class="form-label">CAP</label>
            <input type="text" name="cap" id="cap" class="form-control dark-input" required>
        </div>
        <div class="mb-3">
            <label for="provincia" class="form-label">Provincia</label>
            <input type="text" name="provincia" id="provincia" class="form-control dark-input" required>
        </div>
        <div class="mb-4">
            <label for="metodo" class="form-label">Metodo di pagamento</label>
            <select name="metodo" id="metodo" class="form-select dark-input">
                <option value="carta">Carta di credito</option>
                <option value="paypal">PayPal</option>
                <option value="bonifico">Bonifico bancario</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Conferma e paga</button>
    </form>
</div>