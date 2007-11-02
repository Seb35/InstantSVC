<?php
error_reporting(E_ALL);
require_once 'ezc/Base/base.php'; 

function __autoload($className) {        
	ezcBase::autoload($className);        
}

require_once(dirname(__FILE__) . '/../Reflection2/type_factory.php');

$factory = new iscReflectionTypeFactoryImpl();
ezcReflectionApi::setReflectionTypeFactory($factory);


class MyApp {
	
	private $classesList;
	private $methodsList;
	private $mainWindow;
	private $glade;
	private $methodCodeTxt;
	private $sourceLang;
	private $notebook;
	
	private $snippets;
	
	public function __construct($snippetFolder = null) {
		$this->glade = new GladeXML(dirname(__FILE__) . '/../Glade/MetaPHP.glade');
		$this->glade->signal_autoconnect_instance($this);
		
		$this->collectWidgets();
		
		$this->initClasses();
		$this->initMethods();
		$this->initSourceView($this->methodCodeTxt, 'echo "\n\n";'."\n\n".
    		'$c = new iscReflectionClass(\'Test\');'."\n".
    		'$m = $c->getMethod(\'sayHello\');'."\n".
			'var_dump($m->getCode());'."\n".
    		'$m->setCode(\'echo "Test";\');'."\n".
    		'$t = new Test();'."\n".
    		'$t->sayHello();');
		
		if (!is_null($snippetFolder)) {
			$this->loadSnippets($snippetFolder);
		}
	}
	
	private function initSourceView($view, $code) {
		if (null == $this->sourceLang) {
			$lm = new GtkSourceLanguagesManager();
	    	$this->sourceLang = $lm->get_language_from_mime_type('application/x-php');
		}
		
		$buffer = GtkSourceBuffer::new_with_language($this->sourceLang);
    	$buffer->set_highlight(true);
    	$buffer->set_text($code);
		
		if ($view == null) {
			$view = GtkSourceView::new_with_buffer($buffer);
		} else {
			$view->set_buffer($buffer);
		}
		
		$view->set_show_line_numbers(true);
		$view->set_show_line_markers(true);
		$view->set_tabs_width(4);
		
		return $view;
	}
	
	private function collectWidgets() {
		$this->classesList = $this->glade->get_widget('classesList'); 
		$this->methodsList = $this->glade->get_widget('methodsList');
		$this->methodCodeTxt = $this->glade->get_widget('methodCodeTxt');
		$this->mainWindow = $this->glade->get_widget('MetaPHP');
		$this->notebook = $this->glade->get_widget('notebook1');
	}
	
	private function loadSnippets($snippetFolder) {
		$d = dir($snippetFolder);
		while (false !== ($entry = $d->read())) {
			//var_dump($snippetFolder.$entry);
			if (is_file($snippetFolder.$entry)) {
   				$this->loadSnippet($entry, $snippetFolder);
			}
		}
		$d->close();
	}
	
	private function loadSnippet($filename, $dir) {
		$content = file_get_contents($dir.$filename);
		var_dump($dir.$filename);
		$vpane = new GtkVPaned();
		$vbox = new GtkVBox(false, 5);
		$vpane->add1($vbox);
		
		$sourceView = $this->initSourceView(null, $content);
		$vbox->pack_start($sourceView, true, true, 0);
		
		$evalButton = new GtkButton();
		$evalButton->set_label('Evaluate Snippet');
		//GtkHButtonBox
		$vbox->pack_start($evalButton, false, false, 0);
		$evalButton->connect_simple('clicked', array($this, 'evalCurrentSnippet'));
		
		$resultView = $this->initSourceView(null, '');
		$vpane->add2($resultView);
		
		$label = new GtkLabel($filename, false);
		$nr = $this->notebook->append_page($vpane, $label);
		$vpane->show_all();
		
		$this->snippets[$nr]->sourceView = $sourceView;
		$this->snippets[$nr]->resultView = $resultView;
	}
	
	private function showCurrentClasses() {
		$model = new GtkListStore(Gtk::TYPE_STRING);

		$classes = get_declared_classes();
		foreach ($classes as $class) {
			$model->append(array($class));	
		}
		
		$this->classesList->set_model($model);
	}
	
	private function initClasses() {
		$this->showCurrentClasses();
		
		$renderer = new GtkCellRendererText();
		$column = new GtkTreeViewColumn("Class", $renderer, "text", 0);
		$this->classesList->append_column($column);
		
		$selection = $this->classesList->get_selection();
		$selection->connect("changed", array($this, "classSelected"));
	}
	
	private function initMethods() {
		$renderer = new GtkCellRendererText();
		$column = new GtkTreeViewColumn("Method", $renderer, "text", 0);
		$this->methodsList->append_column($column);
		
		$selection = $this->methodsList->get_selection();
		$selection->connect("changed", array($this, "methodSelected"));
	}
	
	public function execCode() {
		$buffer = $this->methodCodeTxt->get_buffer();
	    $code = $buffer->get_text($buffer->get_start_iter(), $buffer->get_end_iter());
	    eval($code);
	    
	    $this->showCurrentClasses();
	}
	
	public function setMethodCode() {
		$selection = $this->methodsList->get_selection();
		list($model, $iter) = $selection->get_selected();
		
	    if (!is_null($iter)) {
	    	$method = $model->get_value($iter, 1);
	    	$buffer = $this->methodCodeTxt->get_buffer();
	    	$code = $buffer->get_text($buffer->get_start_iter(), $buffer->get_end_iter());
	    	
	    	
	    	try {
	    		$method->setCode($code);
	    		$this->showCurrentClasses();
	    	} catch (Exception $e) {
	    		$dialog = new GtkMessageDialog(
				    null, //$this->mainWindow,//parent
				    0,
				    Gtk::MESSAGE_ERROR,
				    Gtk::BUTTONS_OK,
				    $e->getMessage()
				);
				/*$dialog->set_markup(
				    'Do <b>you</b> like PHP-Gtk '
				    . '<span foreground="red">2</span>?'
				);*/
				$answer = $dialog->run();
				$dialog->destroy();
	    	}
	    }
	}

	public function classSelected($selection) {
		//get_selected returns the store and the iterator for that row
	    list($classModel, $iter) = $selection->get_selected();
	    
	    if (!is_null($iter)) {
		    $model = new GtkListStore(Gtk::TYPE_STRING, Gtk::TYPE_PHP_VALUE);
		    $className = $classModel->get_value($iter, 0);
		    
		    if (class_exists($className)) {
			    $class = new iscReflectionClass($className);
			    $methods = $class->getMethods();
			
				foreach ($methods as $method) {
					$model->append(array($method->getName(), $method));	
				}
				$this->methodsList->set_model($model);
		    }
	    }
	}
	
	public function methodSelected($selection) {
		//get_selected returns the store and the iterator for that row
	    list($model, $iter) = $selection->get_selected();
	    
	    if (!is_null($iter)) {
	    	$method = $model->get_value($iter, 1);
	    	$code = $method->getCode();
	    	
	    	$buffer = GtkSourceBuffer::new_with_language($this->sourceLang);
	    	$buffer->set_highlight(true);
	    	$buffer->set_text($code);
			
	    	$this->methodCodeTxt->set_buffer($buffer);
	    }
	}
	
	public function evalCurrentSnippet() {
		$nr = $this->notebook->get_current_page();
		if ($nr != -1) {
			$buffer = $this->snippets[$nr]->sourceView->get_buffer();
	    	$code = $buffer->get_text($buffer->get_start_iter(), $buffer->get_end_iter());
	    	var_dump($code);
	    	ob_start();
	    	eval($code);
	    	$result = ob_get_clean();
	    	
	    	$this->snippets[$nr]->resultView->get_buffer()->set_text($result);
	    
	    	$this->showCurrentClasses();
		}
	}
}

include('test.php');

$app = new MyApp(dirname(__FILE__).'/../test/');

//Start the main loop
Gtk::main();

echo ':: APP EXIT';
?>
