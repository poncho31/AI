<?php

use GillesPinchart\Ai\api\ollama\mistral_api;
use GillesPinchart\Ai\constructors\Html\Html;

Html::begin("example");

// (new mistral_api())->run();

?>
    <div class="app-container">
        <label for="table">Example vue</label>
        <table id="table">
            <thead>
                <tr>
                    <th>TEST</th>
                    <th>TEST</th>
                    <th>TEST</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>TEST</td>
                    <td>TEST</td>
                    <td>TEST</td>
                </tr>
            </tbody>
        </table>
    </div>
<?php Html::end("example"); ?>