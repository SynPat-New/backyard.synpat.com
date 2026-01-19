<?php
namespace Google\Cloud\Samples\Translate;

/**
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

# [START translate_quickstart]
# Includes the autoloader for libraries installed with composer
require __DIR__ . '/application/libraries/translate/vendor/autoload.php';

# Imports the Google Cloud client library
use Google\Cloud\Translate\TranslateClient;

# Your Google Cloud Platform project ID
$projectId = 'crucial-matter-150221';

# Instantiates a client
$translate = new TranslateClient([
    'projectId' => $projectId
]);
$text = '华为终端有限公司';
// $targetLanguage = 'ja';  // Which language to translate to?
 $model = 'base';  // "base" for standard edition, "nmt" for premium
# Your Google Cloud Platform project ID
$projectId = 'crucial-matter-150221';

# Instantiates a client
$translate = new TranslateClient([
    'projectId' => $projectId
]);

$result = $translate->translate($text, [
    'model'  => $model,
]);
echo "<pre>";
print_r($result);
print("Source language: $result[source]\n");
print("Translation: $result[text]\n");
print("Model: $result[model]\n");
// [END translate_text_with_model]
