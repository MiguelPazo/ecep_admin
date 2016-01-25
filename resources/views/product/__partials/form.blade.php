<div class="row z-depth-1 grey lighten-5 form-new">
    <div class="col s12">
        <div class="input-field col s12">
            <i class="material-icons prefix">&#xE22B;</i>
            <input id="alias" type="text" class="validate">
            <label for="alias">Alias</label>
        </div>
        <div class="input-field col s12">
            <i class="material-icons prefix">&#xE253;</i>
            <textarea id="description" class="materialize-textarea"></textarea>
            <label for="description">Descripción</label>
        </div>
        <div class="input-field col s12">
            <i class="material-icons prefix">&#xE227;</i>
            <input id="price" type="text" class="validate">
            <label for="price">Precio</label>
        </div>
        <div class="input-field col s12">
            <i class="material-icons prefix">&#xE886;</i>
            <select multiple>
                <option value="" disabled selected>Categoría</option>
                @for($i = 1; $i<21;$i++)
                    <option value="{{ $i }}">Categoría {{ $i }}</option>
                @endfor
            </select>
            <label>Seleccione por lo menos una categoría para el producto:</label>
        </div>
        <div class="btn-options right">
            <button type="button" class=" modal-action modal-close waves-effect waves-light btn grey">Cancelar</button>
            <button type="submit" class=" modal-action modal-close waves-effect waves-light btn">Guardar</button>
        </div>
    </div>
</div>
