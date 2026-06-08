<?php

namespace Database\Seeders;

use App\Models\SystemConfiguration;
use Illuminate\Database\Seeder;

class SystemConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $configurations = [
            ['config_key' => 'sla.critical_hours',
            'config_value' => 4,
            'description' => 'SLA hours for critical priority tickets',
            ],
            ['config_key' => 'sla.high_hours',
            'config_value' => 8,
            'description' => 'SLA hours for high priority tickets',
            ],
            ['config_key' => 'sla.medium_hours',
            'config_value' => 24,
            'description' => 'SLA hours for medium priority tickets',
            ],
            ['config_key' => 'sla.low_hours',
            'config_value' => 72,
            'description' => 'SLA hours for low priority tickets',
            ],
            ['config_key' => 'sla.critical_hours',
            'config_value' => 4,
            'description' => 'SLA hours for critical priority tickets',
            ],
            ['config_key' => 'ticket.max_attachments',
            'config_value' => 10,
            'description' => 'Maximum number of attachments per ticket',
            ],
            ['config_key' => 'notification.email_enabled',
            'config_value' => true,
            'description' => 'Enable or disable email notifications',
            ],
            ['config_key' => 'notifications.channels',
            'config_value' => ['database', 'mail'],
            'description' => 'Active notification channel',
            ],
            ['config_key' => 'app.maintenance_mode',
            'config_value' => false,
            'description' => 'Enable or disable maintenance mode',
            ],
            ['config_key' => 'ticket.auto_close_days',
            'config_value' => 7,
            'description' => 'Days after resolved before ticket is auto closed.',
            ],
        ];

        foreach ($configurations as $config) {
            SystemConfiguration::updateOrCreate(
                ['config_key' => $config['config_key']],
                [
                    'config_value' => $config['config_value'],
                    'description' => $config['description'],
                    'updated_at' => now()
                ]
            );
        }
    }
}
