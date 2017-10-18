<?php
    Class Spy
    {
        /* @var string Default exit option */
        private static $EXIT_OPTION = '0';

        /* @var string Histoory of instructions */        
        private static $history = '';

        /* @var Array Array containing possible instructions */
        private static $INSTRUCTIONS = [];

        /**
         * Constructor of a Cellduh
         */
        public function __construct()
        {
            self::$INSTRUCTIONS = [
                [
                    'command' => 'Rest',
                    'message' => 'Rest'."\n",
                    'function' => function() {}
                ],
                [
                    'command' => 'Date',
                    'message' => 'Today\'s date',
                    'function' => function() {
                        echo "\n" . 'Today is:' . "\n" . date('d-m-Y') . "\n\n";
                    }
                ],
                [
                    'command' => 'Time',
                    'message' => 'The time',
                    'function' => function() {
                        echo "\n" . 'Now it\'s:' . "\n" . date('h:i:s') . "\n\n";
                    }
                ],
                [
                    'command' => 'IP',
                    'message' => 'My direction',
                    'function' => function() {
                        $ipaddress = 'UNKNOWN direction';
                        if (getenv('HTTP_CLIENT_IP'))
                        {
                            $ipaddress = getenv('HTTP_CLIENT_IP');
                        }
                        else if(getenv('HTTP_X_FORWARDED_FOR'))
                        {
                            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
                        }
                        else if(getenv('HTTP_X_FORWARDED'))
                        {
                            $ipaddress = getenv('HTTP_X_FORWARDED');
                        }
                        else if(getenv('HTTP_FORWARDED_FOR'))
                        {
                            $ipaddress = getenv('HTTP_FORWARDED_FOR');
                        }
                        else if(getenv('HTTP_FORWARDED'))
                        {
                           $ipaddress = getenv('HTTP_FORWARDED');
                        }
                        else if(getenv('REMOTE_ADDR'))
                        {
                            $ipaddress = getenv('REMOTE_ADDR');
                        }

                        echo "\n" . 'Your IP is:' . "\n";
                        echo $ipaddress . "\n\n";
                    }
                ],
                [
                    'command' => 'Show history',
                    'message' => 'Instructions history',
                    'function' => function() {
                        echo "\n" . 'Instructions history' . "\n" . self::$history . "\n\n";
                    }
                ],
                [
                    'command' => 'Location',
                    'message' => 'Show location',
                    'function' => function() {
                        echo "\n" . 'Spy@' . getcwd() . "\n\n";
                    }
                ]
            ];
            self::$history .= date('h:i:s') . ' -- new spy created' . "\n";
        }

        /**
         * Extends history
         *
         * @param string $newHistory new instruction command to append
         */
        private function extendHistory($newHistory = NULL)
        {
            if (!is_null($newHistory))
            {
                self::$history .= date('h:i:s') . ' -- ' . $newHistory . "\n";
            }
        }

        /**
         * Starts spy
         */
        public function start()
        {
            echo 'Welcome commander!' . "\n";
            do
            {
                $this->showMenu();
                $userInput = trim(fgets(STDIN));
                $this->executeFunctionality($userInput);
                sleep(1);

            } while ($userInput != self::$EXIT_OPTION);

            echo 'Have a nice day commander!' . "\n";
        }

        /**
         * Shows the menu
         */
        private function showMenu()
        {
            echo 'What do you need?' . "\n";
            for ($i = 1; $i < count(self::$INSTRUCTIONS); $i++)
            {
                echo $i . ' - ' . self::$INSTRUCTIONS[$i]['message'] . "\n";
            }
            echo '0 - ' . self::$INSTRUCTIONS[self::$EXIT_OPTION]['message'] . "\n";
            echo 'Enter your wish...' . "\n";
        }

        /**
         * Executes a funtionality depending on the option,
         * entered by the user.
         *
         * @param string $option option of the command to execute
         */
        private function executeFunctionality($option = NULL)
        {
            if (!is_null($option) 
                && $option >= 0 
                && $option <= count(self::$INSTRUCTIONS) - 1)
            {
                $this->extendHistory(self::$INSTRUCTIONS[$option]['command']);
                self::$INSTRUCTIONS[$option]['function']();
            }
        }
    }

    /* Creates a spy and starts it */
    $spy = (new Spy())->start();
?>