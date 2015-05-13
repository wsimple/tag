<?php
session_start();

$word_1 = '';
$word_2 = '';
$words="Accurate,Acrylic,Adaptation,Addition,Adhesive,Aesthetic,Alternate,Aluminium,Ammeter,Amps,Analysis,Angle,Anodising,Anti-clockwise,Anvil,Apart,Appearance,Arc,Arched,Arrowhead,Artefact,Axle,Balance,Battery,Beading,Bearing,Beech,Belts,Bending,Bevel,Border,Brainstorm,Brief,Brief,Buckling,Buffing,Bulb,Bush,Buzzer,Calliper,Cams,Cantilever,Capacitor,Case,Casting,Cedar,Centre,Chain,Chamfer,Channel,Chisel,Chosen,Chuck,Circle,Circumference,Clamp,Clockwise,Coating,Colours,Column,Communicate,Compass,Components,Composite,Compression,Concentric,Conductivity,Conductor,Cone,Consistent,Construction,Contact,Contents,Continuous,Coping,Correct,Corrosion,Corrugated,Counterbore,Countersink,Cranks,Crayon,Critical,Cuboid,Cumulative,Curve,Cutting,Cylinder,Dark,Dash,Design,Development,Device,Diagonal,Diagram,Diameter,Dimension,Diode,Disappear,Distance,Divide,Dotted,Dovetail,Dowel,Draughtsman,Drawing,Ductile,Dynamic,Edge,Effort,Electricity,Electrolytic,Elevation,Ellipse,Environment,Epoxy,Equilibrium,Eraser,Ergonomics,Errors,Evaluation,Exact,Exercise,Expansion,Exploded,Extension,Faint,Files,Flap,Flux,Folding,Font,Forging,Forming,Freehand,Friction,Fulcrum,Function,Fuse,Galvanising,Gauge,Gears,Girder,Glue,Grades,Graph,Graphics,Grid,Grinding,Gritty,Guideline,Hacksaw,Hatching,Heating,Hidden,Highlight,Honeycomb,Horizontal,Idea,Identify,Idler,Impact,Initial,Injection,Insulators,Isometric,Joining,Knurling,Laminating,Landscape,Lathe,Layout,Leader,Left-hand,Length,Lettering,Lever,Light,Linear,Linkage,Logo,Lubricate,Machine,Mahogany,Maintenance,Malleable,Mallet,Mark,Material,Measurement,Measuring,Mechanism,Metallic,Method,Metric,Middle,Millimetre,Milling,Model,Moments,Mould,Need,Net,Nails,Natural,Needle,Object,Oblique,Obtain,Ohms,Operation,Opportunity,Orientation,Original,Orthographic,Oscillating,Outline,Output,Oval,Oxyacetylene,Painting,Paper,Parallel,Parting,Pattern,Pawl,Pencil,Personal,Perspective,Pictorial,Pictures,Pilot,Pincers,Pinion,Pivot,Plan,Planes,Planning,Plating,Pliers,Plywood,Point,Polishing,Polyester,Polystyrene,Polythene,Posidrive,Position,Potential,Presentation,Prism,Procedure,Process,Projection,Proportion,Proposed,Pyramid,Questionnaire,Quality,Quantity,Rack,Radius,Rasp,Ratchet,Ratio,Realisation,Reciprocating,Rectangle,Redundant,Reflection,Regulations,Relay,Reliable,Rendering,Repeat,Require,Research,Resistance,Resistor,Right-angle,Right-hand,Rivet,Rotary,Rough,Routing,Row,Rule,Safety,Schedule,Schematic,Scissors,Score,Screwdriver,Scriber,Series,Shading,Shaft,Shape,Shell,Similar,Situation,Sketch,Smooth,Snail,Snips,Soldering,Spanner,Specification,Sphere,Square,Squiggles,Staining,Standards,Static,Straight,Strength,Strip,Structure,Strut,Styles,Surface,Suspension,System,Tailstock,Tangent,Taper,Tapping,Technical,Technique,Tenon,Tension,Text,Texture,Thick,Thin,Threading,Tie,Timer,Title,Torsion,Toughness,Transistor,Triangle,Triangulation,Truss,Trysquare,Twist,Underline,Unique,Vacuum,Varnish,Vertical,Vice,View,Visible,Visual,Voltmeter,Wastage,Waterproof,Wattage,Weight,Welding,Width,Woodgrain,Worm,Zero,Zigzag";
$words=explode(',',$words);
$wordsId=array_rand($words, 2);

$word_1 = substr($words[$wordsId[0]],0,7);
$word_2 = substr($words[$wordsId[1]],0,7);

$_SESSION['ws-tags'][register][img_captcha] = strtolower($word_1.' '.$word_2);
session_write_close();

$dir = 'fonts/';

$image = imagecreatetruecolor(260, 50);

$font = "recaptchaFont.ttf"; // font style

$color = imagecolorallocate($image, 0, 0, 0);// color

$white = imagecolorallocate($image, 255, 255, 255); // background color white

imagefilledrectangle($image, 0,0, 709, 99, $white);

imagettftext ($image, 22, 0, 5, 30, $color, $dir.$font, $_SESSION['ws-tags'][register][img_captcha]);

header("Content-type: image/png");

imagepng($image);  
