<?php

namespace proj4php\projCode;

/**
 * Author : Julien Moquet
 *
 * Inspired by Proj4JS from Mike Adair madairATdmsolutions.ca
 *                      and Richard Greenwood rich@greenwoodma$p->com
 * License: LGPL as per: http://www.gnu.org/copyleft/lesser.html
 */
/*******************************************************************************
  NAME                  		SINUSOIDAL

  PURPOSE:	Transforms input longitude and latitude to Easting and
  Northing for the Sinusoidal projection.  The
  longitude and latitude must be in radians.  The Easting
  and Northing values will be returned in meters.

  PROGRAMMER              DATE
  ----------              ----
  D. Steinwand, EROS      May, 1991

  This function was adapted from the Sinusoidal projection code (FORTRAN) in the
  General Cartographic Transformation Package software which is available from
  the U.S. Geological Survey National Mapping Division.

  ALGORITHM REFERENCES

  1.  Snyder, John P., "Map Projections--A Working Manual", U.S. Geological
  Survey Professional Paper 1395 (Supersedes USGS Bulletin 1532), United
  State Government Printing Office, Washington D.C., 1987.

  2.  "Software Documentation for GCTP General Cartographic Transformation
  Package", U.S. Geological Survey National Mapping Division, May 1982.
 * ***************************************************************************** */

use proj4php\Proj4php;
use proj4php\Common;
use proj4php\Point;

class Sinu
{
    public $C_x;
    public $C_y;
    public $a;
    public $en;
    public $es;
    public $long0;
    public $m;
    public $n;
    public $x0;
    public $y0;

    /**
     * Initialize the Sinusoidal projection
     */
    public function init()
    {
        // Place parameters in static storage for common use
        #$this->R = 6370997.0; //Radius of earth

        if (isset($this->sphere)) {
            //fixes SR-ORG:6965
            $this->en = Common::pj_enfn($this->es);
        } else {
            $this->n = 1.;
            $this->m = 0.;
            $this->es = 0;
            $this->C_y = sqrt(($this->m + 1.) / $this->n);
            $this->C_x = $this->C_y / ($this->m + 1.);
        }
    }

    /**
     * Sinusoidal forward equations--mapping lat,long to x,y
     */
    public function forward($p)
    {
        #$x,y,delta_lon;
        $lon = $p->x;
        $lat = $p->y;

        // Forward equations

        $lon = Common::adjust_lon($lon - $this->long0);

        if (isset($this->sphere)) {
            if (!$this->m) {
                $lat = $this->n != 1. ? asin($this->n * sin($lat)) : $lat;
            } else {
                $k = $this->n * sin($lat);
                for ($i = Common::MAX_ITER; $i; --$i) {
                    $V = ($this->m * $lat + sin($lat) - $k) / ($this->m + cos($lat));
                    $lat -= $V;

                    if (abs($V) < Common::EPSLN) {
                        break;
                    }
                }
            }

            $x = $this->a * $this->C_x * $lon * ($this->m + cos($lat));
            $y = $this->a * $this->C_y * $lat;
        } else {
            $s = sin($lat);
            $c = cos($lat);

            $y = $this->a * Common::pj_mlfn($lat, $s, $c, $this->en);
            $x = $this->a * $lon * $c / sqrt(1.0 - $this->es * $s * $s);
        }

        $p->x = $x;
        $p->y = $y;

        return $p;
    }

    /**
     * @param Point $p
     * @return Point
     */
    public function inverse($p)
    {
        #$lat;
        #$temp;
        #$lon;

        // Inverse equations

        $p->x -= $this->x0;
        $p->y -= $this->y0;

        $lat = $p->y / $this->a;

        if (isset($this->sphere)) {
            $p->y /= $this->C_y;
            $lat = $this->m ? asin(($this->m * $p->y + sin($p->y)) / $this->n) : ($this->n != 1. ? asin(sin($p->y) / $this->n) : $p->y);
            $lon = $p->x / ($this->C_x * ($this->m + cos($p->y)));
        } else {
            $lat = Common::pj_inv_mlfn($p->y / $this->a, $this->es, $this->en);
            $s = abs($lat);

            if ($s < Common::HALF_PI) {
                $s = sin($lat);
                $temp = $this->long0 + $p->x * sqrt(1. - $this->es * $s * $s) / ($this->a * cos($lat));
                //temp = $this->long0 + $p->x / ($this->a * cos($lat));
                $lon = Common::adjust_lon($temp);
            } else if (($s - Common::EPSLN) < Common::HALF_PI) {
                $lon = $this->long0;
            }
        }

        $p->x = $lon;
        $p->y = $lat;

        return $p;
    }
}
