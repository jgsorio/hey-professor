<?php

namespace App\Console\GitHooks;

use Closure;
use Igorsgm\GitHooks\Contracts\PreCommitHook;
use Igorsgm\GitHooks\Git\ChangedFiles;
use Symfony\Component\Process\Process;

class TestingPreCommitHook implements PreCommitHook
{
    /**
     * Get the name of the hook.
     */
    public function getName(): ?string
    {
        return 'Testing Pre Commit Hook';
    }

    /**
     * Execute the Hook.
     *
     * @param  ChangedFiles  $files  The list of changed files to analyze.
     * @param  Closure  $next  The next hook in the chain to execute.
     * @return mixed|null
     */
    public function handle(ChangedFiles $files, Closure $next)
    {
        $process = new Process(['./vendor/bin/pest']);
        $process->run();

        if (! $process->isSuccessful()) {
            return $process->getErrorOutput();
        }

        return $next($files);
    }
}
