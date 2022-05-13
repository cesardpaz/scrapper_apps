<div class="container-fluid">

    <div class="row">

        <div class="col-12">
            <h2>Scrapper of Apps</h2>
        </div>

        <div class="col-12">
            <form id="form_scrapper">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Insert URLs for add Apps</label>
                    <textarea rows="6" id="urls_scrapp" class="form-control"></textarea>
                    <div id="emailHelp" class="form-text"><a href="">View documentation <span class="material-icons">contact_support</span></a></div>
                </div>
                <div class="mb-3">

                    <div class="form-check">
                        <input class="form-check-input" value="juego" type="radio" name="app_type" id="app_juego" checked>
                        <label class="form-check-label" for="app_juego">
                            Juego
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" value="aplicacion" type="radio" name="app_type" id="app_aplicacion">
                        <label class="form-check-label" for="app_aplicacion">
                            Aplicación
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Send</button>
            </form>
        </div>
        
    </div>
</div>