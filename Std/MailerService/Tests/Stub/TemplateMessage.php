<?php
/**
 * PHP version 7
 * File AbstractMessage.php
 *
 * @category Module
 * @package  Std\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\MailerService\Tests\Stub;

use Std\MailerService\Message;

/**
 * Class AbstractMessage
 *
 * @category Class
 * @package  Std\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class TemplateMessage extends Message
{
    protected $template = 'html.twig';
    protected $textTemplate = 'text.twig';
    protected $data = [
        'title' => 'メールテンプレーツテスト',
        'User' => [
            'name' => 'テスト担当者',
        ],
        'Project' => [
            'name' => 'メールテスト',
            'link' => 'https://github.com/git-ski/framework.git',
            'members' => [
            ],
        ]
    ];

    /**
     * Method getTemplateDir
     *
     * @return string $templateDir
     */
    public function getTemplateDir()
    {
        return __DIR__ . '/template/';
    }
}
