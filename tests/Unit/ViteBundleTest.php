<?php

namespace App\Tests\Unit;

use Pentatrion\ViteBundle\Service\EntrypointsLookupCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ViteBundleTest extends KernelTestCase
{
    private EntrypointsLookupCollection $entrypointsLookupCollection;
    private string $projectDir;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::getContainer();
        
        $this->entrypointsLookupCollection = $container->get(EntrypointsLookupCollection::class);
        $this->projectDir = $container->getParameter('kernel.project_dir');
    }

    /**
     * Test que le fichier entrypoints.json existe et est accessible.
     */
    public function testEntrypointsFileExists(): void
    {
        $entrypointsPath = $this->projectDir . '/public/build/.vite/entrypoints.json';
        
        $this->assertFileExists($entrypointsPath, 'Le fichier entrypoints.json doit exister');
        $this->assertFileIsReadable($entrypointsPath, 'Le fichier entrypoints.json doit être lisible');
    }

    /**
     * Test que le fichier entrypoints.json contient un JSON valide.
     */
    public function testEntrypointsFileIsValidJson(): void
    {
        $entrypointsPath = $this->projectDir . '/public/build/.vite/entrypoints.json';
        $content = file_get_contents($entrypointsPath);
        
        $data = json_decode($content, true);
        
        $this->assertNotNull($data, 'Le fichier entrypoints.json doit contenir du JSON valide');
        $this->assertIsArray($data, 'Le contenu doit être un tableau');
    }

    /**
     * Test que l'entrée 'app' existe et contient des fichiers CSS et JS.
     */
    public function testAppEntryPointExists(): void
    {
        $entrypointsPath = $this->projectDir . '/public/build/.vite/entrypoints.json';
        $content = file_get_contents($entrypointsPath);
        $data = json_decode($content, true);
        
        $this->assertArrayHasKey('entryPoints', $data, 'Le fichier doit contenir une clé "entryPoints"');
        $this->assertArrayHasKey('app', $data['entryPoints'], 'L\'entrée "app" doit exister');
        
        $appEntry = $data['entryPoints']['app'];
        
        $this->assertArrayHasKey('css', $appEntry, 'L\'entrée "app" doit avoir des fichiers CSS');
        $this->assertArrayHasKey('js', $appEntry, 'L\'entrée "app" doit avoir des fichiers JS');
        
        $this->assertNotEmpty($appEntry['css'], 'L\'entrée "app" doit avoir au moins un fichier CSS');
        $this->assertNotEmpty($appEntry['js'], 'L\'entrée "app" doit avoir au moins un fichier JS');
    }

    /**
     * Test que le service EntrypointsLookupCollection peut récupérer les fichiers JS.
     */
    public function testEntrypointsLookupCanGetJsFiles(): void
    {
        $entrypointsLookup = $this->entrypointsLookupCollection->getEntrypointsLookup();
        
        $jsFiles = $entrypointsLookup->getJSFiles('app');
        
        $this->assertIsArray($jsFiles, 'getJSFiles doit retourner un tableau');
        $this->assertNotEmpty($jsFiles, 'L\'entrée "app" doit avoir au moins un fichier JS');
        
        // Vérifier que le chemin commence par /build/
        foreach ($jsFiles as $jsFile) {
            $this->assertStringStartsWith('/build/', $jsFile, 'Les fichiers JS doivent commencer par /build/');
        }
    }

    /**
     * Test que le service EntrypointsLookupCollection peut récupérer les fichiers CSS.
     */
    public function testEntrypointsLookupCanGetCssFiles(): void
    {
        $entrypointsLookup = $this->entrypointsLookupCollection->getEntrypointsLookup();
        
        $cssFiles = $entrypointsLookup->getCSSFiles('app');
        
        $this->assertIsArray($cssFiles, 'getCSSFiles doit retourner un tableau');
        $this->assertNotEmpty($cssFiles, 'L\'entrée "app" doit avoir au moins un fichier CSS');
        
        // Vérifier que le chemin commence par /build/
        foreach ($cssFiles as $cssFile) {
            $this->assertStringStartsWith('/build/', $cssFile, 'Les fichiers CSS doivent commencer par /build/');
        }
    }

    /**
     * Test que les fichiers d'assets buildés existent physiquement.
     */
    public function testBuiltAssetsExist(): void
    {
        $entrypointsLookup = $this->entrypointsLookupCollection->getEntrypointsLookup();
        
        $jsFiles = $entrypointsLookup->getJSFiles('app');
        $cssFiles = $entrypointsLookup->getCSSFiles('app');
        
        // Vérifier que les fichiers JS existent
        foreach ($jsFiles as $jsFile) {
            $fullPath = $this->projectDir . '/public' . $jsFile;
            $this->assertFileExists($fullPath, "Le fichier JS $jsFile doit exister physiquement");
        }
        
        // Vérifier que les fichiers CSS existent
        foreach ($cssFiles as $cssFile) {
            $fullPath = $this->projectDir . '/public' . $cssFile;
            $this->assertFileExists($fullPath, "Le fichier CSS $cssFile doit exister physiquement");
        }
    }

    /**
     * Test que le viteServer est null (mode production).
     */
    public function testViteServerIsNull(): void
    {
        $entrypointsPath = $this->projectDir . '/public/build/.vite/entrypoints.json';
        $content = file_get_contents($entrypointsPath);
        $data = json_decode($content, true);
        
        $this->assertArrayHasKey('viteServer', $data, 'Le fichier doit contenir une clé "viteServer"');
        $this->assertNull($data['viteServer'], 'viteServer doit être null en mode production');
    }
}
