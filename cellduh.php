<?php
    Class Cellduh
    {
        /* @var string Default exit option */
        private static $EXIT_OPTION = '0';

        /* @var string Histoory of instructions */        
        private static $history = '';

        /* @var Array[string] Array of strings, containing possible instructions */
        private static $INSTRUCTIONS = [];

        /**
         * Constructor of a Cellduh
         */
        public function __construct()
        {
            self::$INSTRUCTIONS = [
                'Rest',
                'Date',
                'Time',
                'IP',
                'Show history'
            ];
            self::$history .= 'Cellduh has been created' . "\n";
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
                self::$history .= $newHistory . "\n";
            }
        }

        /**
         * Starts cellduh
         */
        public function start()
        {
            echo 'Welcome commander!' . "\n";
            do
            {
                $this->showMenu();
                $userInput = trim(fgets(STDIN));
                $this->executeFunctionality($userInput);

            } while ($userInput != self::$EXIT_OPTION);

            echo 'Have a nice day commander!' . "\n";
        }

        /**
         * Shows the menu
         */
        private function showMenu()
        {
            echo 'What do you need?' . "\n";
            echo '1 - Today\'s date' . "\n";
            echo '2 - The time' . "\n";
            echo '3 - My direction' . "\n";
            echo '4 - Instructions history' . "\n";
            echo '0 - Rest' . "\n\n";
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
            if (!is_null($option) && $option >= 0 && $option <= count(self::$INSTRUCTIONS) - 1)
            {
                $this->extendHistory(self::$INSTRUCTIONS[$option]);
                switch ($option) {
                    case '1':
                        $this->getTodayDate();
                        break;
                    case '2':
                        $this->getCurrentTime();
                        break;
                    case '3':
                        $this->getIP();
                    case '4':
                    $this->getHistory();
                        break;
                    default:
                        break;
                }
            }
        }

        /**
         * Echoes today's day, month and year
         */
        private function getTodayDate()
        {
            echo "\n" . 'Today is:' . "\n";
            echo date('d-m-Y') . "\n\n";
            sleep(1);
        }

        /**
         * Echoes current time in hours, minutes and seconds
         */
        private function getCurrentTime()
        {
            echo "\n" . 'Now it\'s:' . "\n";
            echo date('h:i:s') . "\n\n";
            sleep(1);
        }

        /**
         * Echoes current IP, only if run from server
         */
        private function getIP() {
            $ipaddress = 'UNKNOWN direction';
            if (getenv('HTTP_CLIENT_IP'))
                $ipaddress = getenv('HTTP_CLIENT_IP');
            else if(getenv('HTTP_X_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
            else if(getenv('HTTP_X_FORWARDED'))
                $ipaddress = getenv('HTTP_X_FORWARDED');
            else if(getenv('HTTP_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_FORWARDED_FOR');
            else if(getenv('HTTP_FORWARDED'))
               $ipaddress = getenv('HTTP_FORWARDED');
            else if(getenv('REMOTE_ADDR'))
                $ipaddress = getenv('REMOTE_ADDR');

            echo "\n" . 'Your IP is:' . "\n";
            echo $ipaddress . "\n\n";
            sleep(1);
        }

        /**
         * Echoes whole history of instructions
         */
        private function getHistory()
        {
            echo "\n" . 'Instructions history' . "\n";
            echo self::$history . "\n\n";
        }
    }

    /* Creates a cellduh and starts it */
    $cellduh = new Cellduh();
    $cellduh->start();
?>