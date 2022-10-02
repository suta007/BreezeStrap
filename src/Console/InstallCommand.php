<?php
namespace Suta007\Breezestrap\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
    protected $signature = 'suta:install';
    protected $description = 'Install Bootstrap for Laravel Breeze';

    public function handle()
    {

        // NPM Packages...
        $this->removeNodePackages([
            "@tailwindcss/forms",
            "alpinejs",
            "autoprefixer",
            "tailwindcss",
        ]);

        $this->updateNodePackages(function ($packages) {
            return [
                'bootstrap' => '^5.2.1',
                'sass' => '^1.55.0',
            ] + $packages;
        });

        (new Filesystem)->deleteDirectory(resource_path('js'));
        (new Filesystem)->deleteDirectory(resource_path('lang'));
        (new Filesystem)->deleteDirectory(resource_path('sass'));
        (new Filesystem)->deleteDirectory(resource_path('views/auth'));
        (new Filesystem)->deleteDirectory(resource_path('views/layouts'));
        (new Filesystem)->deleteDirectory(resource_path('views/components'));

        (new Filesystem)->ensureDirectoryExists(resource_path('js'));
        (new Filesystem)->ensureDirectoryExists(resource_path('lang'));
        (new Filesystem)->ensureDirectoryExists(resource_path('sass'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/auth'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/components'));
        (new Filesystem)->ensureDirectoryExists(public_path('images'));

        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/js', resource_path('js'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/lang', resource_path('lang'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/sass', resource_path('sass'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/auth', resource_path('views/auth'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/layouts', resource_path('views/layouts'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/components', resource_path('views/components'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../images', public_path('images'));

        (new Filesystem)->delete(resource_path('views/dashboard.blade.php'));
        copy(__DIR__ . '/../../resources/views/dashboard.blade.php', resource_path('views/dashboard.blade.php'));

        (new Filesystem)->delete(base_path('vite.config.js'));
        copy(__DIR__ . '/../../vite.config.js', base_path('vite.config.js'));

        copy(__DIR__ . '/../../favicon.ico', public_path('favicon.ico'));
        copy(__DIR__ . '/../../LoginRequest.php', app_path('Http/Requests/Auth/LoginRequest.php'));
        copy(__DIR__ . '/../../2014_10_12_000000_create_users_table.php', base_path('database/migrations/2014_10_12_000000_create_users_table.php'));

        (new Filesystem)->delete(base_path('tailwind.config.js'));
        (new Filesystem)->delete(base_path('postcss.config.js'));

        $this->runCommands(['npm install', 'npm run build']);

        $this->line('');
        $this->components->info('BreezeStrap installed successfully.');
    }

    /**
     * Installs the given Composer Packages into the application.
     *
     * @param  mixed  $packages
     * @return void
     */
    protected function requireComposerPackages($packages)
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = ['php', $composer, 'require'];
        }

        $command = array_merge(
            $command ?? ['composer', 'require'],
            is_array($packages) ? $packages : func_get_args()
        );

        (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });
    }

    /**
     * Update the "package.json" file.
     *
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (!file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }

    protected static function removeNodePackages($rPackges, $dev = true)
    {
        if (!file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        foreach ($packages[$configurationKey] as $key => $item) {
            if (in_array($key, $rPackges)) {
                unset($packages[$configurationKey][$key]);
            }
        }

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }

    /**
     * Delete the "node_modules" directory and remove the associated lock files.
     *
     * @return void
     */
    protected static function flushNodeModules()
    {
        tap(new Filesystem, function ($files) {
            $files->deleteDirectory(base_path('node_modules'));

            $files->delete(base_path('yarn.lock'));
            $files->delete(base_path('package-lock.json'));
        });
    }

    /**
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    /**
     * Get the path to the appropriate PHP binary.
     *
     * @return string
     */
    protected function phpBinary()
    {
        return (new PhpExecutableFinder())->find(false) ?: 'php';
    }

    protected function runCommands($commands)
    {
        $process = Process::fromShellCommandline(implode(' && ', $commands), null, null, null, null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            try {
                $process->setTty(true);
            } catch (RuntimeException $e) {
                $this->output->writeln('  <bg=yellow;fg=black> WARN </> ' . $e->getMessage() . PHP_EOL);
            }
        }

        $process->run(function ($type, $line) {
            $this->output->write('    ' . $line);
        });
    }
}
