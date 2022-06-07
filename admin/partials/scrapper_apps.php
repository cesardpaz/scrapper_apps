<div class="pr-4">
    <div class="bg-white shadow-sm mb-4 my-4">
        <h2 class="font-bold text-xl tracking-wide p-3 border-b border-gray-200">Scrapper of Apps</h2>
        <div class="p-3">
            <div id="form_scrapper" class="w-full"">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2" for="urls_scrapp">Insert URLs of moobion.com</label>
                    <textarea id="urls_scrapp" class="appearance-none border border-gray-200 rounded w-full py-3 px-4 text-black leading-tight focus:outline-none" rows="5"></textarea>
                    <p class="mt-2 text-sm text-gray-400">Page web of moobion <a target="_blank" href="https://www.moobion.com/" class="font-medium text-blue-400 hover:underline">Moobion</a>.</p>
                </div>

                <div class="mb-4">
                    <fieldset>
                        <label class="block text-gray-700 text-sm mb-3" for="username">Type of App</label>

                        <div class="flex items-center mb-4">
                            <input id="app_juego" type="radio" name="app_type" value="juego" class="w-4 h-4 border-gray-300" checked>
                            <label for="app_juego" class="block ml-2 text-sm font-medium text-black">Juego</label>
                        </div>
                        <div class="flex items-center mb-4">
                            <input id="app_aplicacion" type="radio" name="app_type" value="aplicacion" class="w-4 h-4 border-gray-300">
                            <label for="app_aplicacion" class="block ml-2 text-sm font-medium text-black">Aplicación</label>
                        </div>
                    </fieldset>
                </div>

                <button id="send-scrapper" class="inline-flex items-center text-white bg-primary hover:bg-blue-600 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5">Scrapper</button>
            </div>
        </div>
    </div>
</div>