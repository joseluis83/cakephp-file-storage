<?php
namespace Burzum\FileStorage\Test\TestCase\Event;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Burzum\FileStorage\Event\ImageProcessingListener;
use Burzum\FileStorage\Model\Table\FileStorageTable;
use Burzum\FileStorage\Model\Table\ImageStorageTable;

class TestImageProcessingListener extends ImageProcessingListener {
	public function buildPath($image, $extension = true, $hash = null) {
		return $this->_buildPath($image, $extension, $hash);
	}
}

/**
 * LocalImageProcessingListener Test
 *
 * @author Florian Krämer
 * @copyright 2012 - 2014 Florian Krämer
 * @license MIT
 *
 * @property ImageProcessingListener $Listener
 */
class ImageProcessingListenerTest extends TestCase {

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Model = new FileStorageTable();
		$this->Listener = new ImageProcessingListener();
	}

/**
 * tearDown
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
		unset($this->Listener, $this->Model);
		TableRegistry::clear();
	}

	public function testBuildPath() {
		$this->Listener = new TestImageProcessingListener(array(
			'preserveFilename' => true,
		));

		$result = $this->Listener->buildPath(array(
			'filename' => 'foobar.jpg',
			'path' => '/xx/xx/xx/uuid/',
			'extension' => 'jpg'
		));
		$this->assertEquals($result, '/xx/xx/xx/uuid/foobar.jpg');

		$result = $this->Listener->buildPath(array(
			'filename' => 'foobar.jpg',
			'path' => '/xx/xx/xx/uuid/',
			'extension' => 'jpg'
		), true, '5gh2hf');
		$this->assertEquals($result, '/xx/xx/xx/uuid/foobar.5gh2hf.jpg');
	}

}