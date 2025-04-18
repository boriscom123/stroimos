<?php

namespace proj4php\projCode;

/*******************************************************************************
  NAME                            CASSINI

  PURPOSE:	Transforms input longitude and latitude to Easting and
  Northing for the Cassini projection.  The
  longitude and latitude must be in radians.  The Easting
  and Northing values will be returned in meters.
  Ported from PROJ.4.


  ALGORITHM REFERENCES

  1.  Snyder, John P., "Map Projections--A Working Manual", U.S. Geological
  Survey Professional Paper 1395 (Supersedes USGS Bulletin 1532), United
  State Government Printing Office, Washington D.C., 1987.

  2.  Snyder, John P. and Voxland, Philip M., "An Album of Map Projections",
  U.S. Geological Survey Professional Paper 1453 , United State Government
 ****************************************************************************** */

/**
 * Author : Julien Moquet
 *
 * Inspired by Proj4JS from Mike Adair madairATdmsolutions.ca
 *                      and Richard Greenwood rich@greenwoodma$p->com
 * License: LGPL as per: http://www.gnu.org/copyleft/lesser.html
 */
//Proj4php.defs["EPSG:28191"] = "+proj=cass +lat_0=31.73409694444445 +lon_0=35.21208055555556 +x_0=170251.555 +y_0=126867.909 +a=6378300.789 +b=6356566.435 +towgs84=-275.722,94.7824,340.894,-8.001,-4.42,-11.821,1 +units=m +no_defs";
// Initialize the Cassini projection
// -----------------------------------------------------------------

use proj4php\Proj4php;
use proj4php\Common;

class Cass
{
    public $a1;
    public $a2;
    public $a;
    public $c;
    public $d2;
    public $dd;
    public $en;
    public $es;
    public $lat0;
    public $long0;
    public $m0;
    public $n;
    public $phi0;
    public $r;
    public $sphere;
    public $t;
    public $tn;
    public $x0;
    public $y0;

    public function init()
    {
        if (!$this->sphere) {
            $this->en = Common::pj_enfn($this->es);
            $this->m0 = Common::pj_mlfn($this->lat0, sin($this->lat0), cos($this->lat0), $this->en);
        }
    }

    protected $C1 = 0.16666666666666666666;
    protected $C2 = 0.00833333333333333333;
    protected $C3 = 0.04166666666666666666;
    protected $C4 = 0.33333333333333333333;
    protected $C5 = 0.06666666666666666666;

    /**
     * Cassini forward equations--mapping lat,long to x,y
     */
    public function forward($p)
    {
        // Forward equations
        $lam = $p->x;
        $phi = $p->y;
        $lam = Common::adjust_lon($lam - $this->long0);

        if ($this->sphere) {
            $x = asin(cos($phi) * sin($lam));
            $y = atan2(tan($phi), cos($lam)) - $this->phi0;
        } else {
            // ellipsoid
            $this->n = sin($phi);
            $this->c = cos($phi);
            $y = Common::pj_mlfn($phi, $this->n, $this->c, $this->en);
            $this->n = 1.0 / sqrt(1.0 - $this->es * $this->n * $this->n);
            $this->tn = tan($phi);
            $this->t = $this->tn * $this->tn;
            $this->a1 = $lam * $this->c;
            $this->c *= $this->es * $this->c / (1 - $this->es);
            $this->a2 = $this->a1 * $this->a1;
            $x = $this->n * $this->a1 * (1.0 - $this->a2 * $this->t * ($this->C1 - (8.0 - $this->t + 8.0 * $this->c) * $this->a2 * $this->C2));
            $y -= $this->m0 - $this->n * $this->tn * $this->a2 * (0.5 + (5. - $this->t + 6. * $this->c) * $this->a2 * $this->C3);
        }

        $p->x = $this->a * $x + $this->x0;
        $p->y = $this->a * $y + $this->y0;

        return $p;
    }

    // Inverse equations
    public function inverse($p)
    {
        $p->x -= $this->x0;
        $p->y -= $this->y0;
        $x = $p->x / $this->a;
        $y = $p->y / $this->a;

        if ($this->sphere) {
            $this->dd = $y + $this->lat0;
            $phi = asin(sin($this->dd) * cos($x));
            $lam = atan2(tan($x), cos($this->dd));
        } else {
            // ellipsoid
            $ph1 = Common::pj_inv_mlfn($this->m0 + $y, $this->es, $this->en);
            $this->tn = tan($ph1);
            $this->t = $this->tn * $this->tn;
            $this->n = sin($ph1);
            $this->r = 1.0 / (1.0 - $this->es * $this->n * $this->n);
            $this->n = sqrt($this->r);
            $this->r *= (1.0 - $this->es) * $this->n;
            $this->dd = $x / $this->n;
            $this->d2 = $this->dd * $this->dd;
            $phi = $ph1 - ($this->n * $this->tn / $this->r) * $this->d2 * (0.5 - (1.0 + 3.0 * $this->t) * $this->d2 * $this->C3);
            $lam = $this->dd * (1.0 + $this->t * $this->d2 * (-$this->C4 + (1.0 + 3. * $this->t) * $this->d2 * $this->C5)) / cos($ph1);
        }

        $p->x = Common::adjust_lon($this->long0 + $lam);
        $p->y = $phi;

        return $p;
    }
}
