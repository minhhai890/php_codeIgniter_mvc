<?php
if (isset($data) && $data) {
    $str = '<div class="banner">
                <div class="image">
                    <a href="' . $data['url'] . '" title="' . $data['title'] . '">
                        <img src="' . $this->getData('dirImage') . $data['image'] . '" alt="' . $data['title'] . '">
                    </a>
                </div>
            </div>';
    return $str;
}
