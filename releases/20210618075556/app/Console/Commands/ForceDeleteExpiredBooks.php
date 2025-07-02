<?php

namespace App\Console\Commands;

use App\Brandbook;
use Illuminate\Console\Command;
use function foo\func;

class ForceDeleteExpiredBooks extends Command{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expired_books:force_delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permanently deletes expired books';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(){

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){

        Brandbook::onlyTrashed()->where( 'deleted_at', '<', now()->addWeeks( -2 ) )->chunk(10, function($brandbooks){
            foreach ( $brandbooks as $book ){
                try{
                    $this->deleteFiles( $book );
                    $book->forceDelete();
                } catch ( \Exception $e ){
                    info( 'ERROR ON DELTING BOOK ' . $book->id );
                    info( $e->getMessage() );
                    info( $e->getTraceAsString() );
                }
            }
        });

    }

    protected function deleteFiles( Brandbook $brandbook ){

        //uploaded custom fonts
        $fonts_main = json_decode( $brandbook->fonts_main, true );
        if ( !empty( $fonts_main ) ){
            foreach ( $fonts_main as $item ){
                if ( !empty( $item ) && !empty($item['file']) && file_exists( public_path( $item[ 'file' ] ) ) ){
                    unlink( public_path( $item[ 'file' ] ) );
                }
            }
        }

        $fonts_secondary = json_decode( $brandbook->fonts_secondary, true );
        if ( !empty( $fonts_secondary ) ){
            foreach ( $fonts_secondary as $item ){
                if ( !empty( $item ) && file_exists( public_path( $item[ 'file' ] ) ) && is_file( public_path( $item[ 'file' ] ) ) ){
                    unlink( public_path( $item[ 'file' ] ) );
                }
            }
        }

        //pdf files

        $pdf_links = json_decode( $brandbook->pdf_link, true );
        if ( !empty( $pdf_links ) ){
            foreach ( $pdf_links as $pdf_link ){
                if ( file_exists( public_path( $pdf_link ) ) ){
                    unlink( public_path( $pdf_link ) );
                }
            }
        }

        //bbassets
        if ( file_exists( storage_path( 'bbassets/' . $brandbook->id ) ) ){
            \File::deleteDirectory( 'bbassets/' . $brandbook->id );
        }
        //admin assets
        if ( file_exists( storage_path( 'bbassets-admin/' . $brandbook->id ) ) ){
            \File::deleteDirectory( 'bbassets-admin/' . $brandbook->id );
        }

        //preview
        if ( file_exists( storage_path( 'previews/' . $brandbook->id . '.jpg' ) ) ){
            unlink( storage_path( 'previews/' . $brandbook->id . '.jpg' ) );
        }


        //custom
        if ( file_exists( public_path( config( 'app.images_path' ) . $brandbook->user_id . '/' . $brandbook->id ) ) ){
            \File::deleteDirectory( public_path( config( 'app.images_path' ) . $brandbook->user_id . '/' . $brandbook->id ) );
        }


    }
}
