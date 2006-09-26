    //=======================================================================
    /**
     * @param string $file
     */
    public CodeAnalyzer::function save($file) {
        $data['stats'] = $this->flatStatsArray;
        $data['docu'] = $this->docuFlaws;
        $render = new RenderEngine($data);
        $render->setTemplate('stats.html');
        $result = $render->fetch();

        $cli = (strpos(php_sapi_name(), 'cli') !== false);
        if ($cli) {
            file_put_contents($file, $result);
        } else {
            echo $result;
        }
    }