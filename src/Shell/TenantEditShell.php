<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Utility\Text;


/**
 * TenantEdit shell command.
 */
class TenantEditShell extends Shell
{

    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();
        // $this->edit();
        return $parser;

    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {
        $this->out($this->OptionParser->help());
        $this->edit();
    }

    public function edit(){

        $this->loadModel('Tenants');
        $tenants = $this->Tenants->find()
                                ->toArray();
        foreach ($tenants as  $tenant) {
            # code...
            if(isset($tenant->uuid) && !empty($tenant->uuid) && (strlen($tenant->uuid) == 6)){
                $this->out('Already Present for '.$tenant->center_name);
                continue;
            }
            $data['uuid'] = $this->_cryptographicString('alnum',6);
            $tenant = $this->Tenants->patchEntity($tenant, $data);
            if(!$this->Tenants->save($tenant)){
                $this->out('Already Present ! '.$tenant->id);
                pr($tenant);die;
            }
            $this->out('Saved successfuly for '.$tenant->center_name);                         
        }

    }

    /*Unique Id generator*/

    private function _cryptographicString( $type = 'alnum', $length = 6 )
    {
      switch ( $type ) {
        case 'alnum':
        $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        break;
        case 'alpha':
        $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        break;
        case 'hexdec':
        $pool = '0123456789abcdef';
        break;
        case 'numeric':
        $pool = '0123456789';
        break;
        case 'nozero':
        $pool = '123456789';
        break;
        case 'distinct':
        $pool = '2345679ACDEFHJKLMNPRSTUVWXYZ';
        break;
        default:
        $pool = (string) $type;
        break;
      }
      $crypto_rand_secure = function ( $min, $max ) {
        $range = $max - $min;
        if ( $range < 0 ) return $min; // not so random...
        $log    = log( $range, 2 );
        $bytes  = (int) ( $log / 8 ) + 1; // length in bytes
        $bits   = (int) $log + 1; // length in bits
        $filter = (int) ( 1 << $bits ) - 1; // set all lower bits to 1
        do {
          $rnd = hexdec( bin2hex( openssl_random_pseudo_bytes( $bytes ) ) );
          $rnd = $rnd & $filter; // discard irrelevant bits
        } while ( $rnd >= $range );
        return $min + $rnd;
      };
      $token = "";
      $max   = strlen( $pool );
      for ( $i = 0; $i < $length; $i++ ) {
        $token .= $pool[$crypto_rand_secure( 0, $max )];
      }
      return $token;
    }
}
