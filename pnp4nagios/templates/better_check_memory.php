<?php

	$opt[1] = "--vertical-label \"Bytes\" -l0 --base=1024 --title \"Memory usage  for $hostname / $servicedesc\" ";

	# Total Memory
	$def[1] = "DEF:mem_total=$RRDFILE[1]:$DS[1]:AVERAGE " ;
	# Used Memory
	$def[1] .= "DEF:mem_used=$RRDFILE[1]:$DS[2]:AVERAGE " ;
	# Cache
	$def[1] .= "DEF:mem_cache=$RRDFILE[1]:$DS[4]:AVERAGE " ;
	# Buffer
	$def[1] .= "DEF:mem_buffer=$RRDFILE[1]:$DS[3]:AVERAGE " ;
	

	# Memory Cache
	$def[1] .= rrd::cdef("mem_cache_tmp", "mem_cache,mem_buffer,+,mem_used,+");
	$def[1] .= rrd::area("mem_cache_tmp", "#193441", "Memory Cache");

	$def[1] .= "GPRINT:mem_cache:LAST:\"%3.2lf %sB LAST \" ";
        $def[1] .= "GPRINT:mem_cache:MAX:\"%3.2lf %sB MAX \" ";
        $def[1] .= "GPRINT:mem_cache" . ':AVERAGE:"%3.2lf %sB AVERAGE \j" ';


	# Memory Used
	$def[1] .= rrd::cdef("mem_used_tmp", "mem_used,mem_buffer,+");
	$def[1]	.= rrd::area("mem_used_tmp", "#3E606F", "Memory Used");

	$def[1] .= "GPRINT:mem_used:LAST:\"%3.2lf %sB LAST \" ";
	$def[1] .= "GPRINT:mem_used:MAX:\"%3.2lf %sB MAX \" ";
	$def[1] .= "GPRINT:mem_used" . ':AVERAGE:"%3.2lf %sB AVERAGE \j" ';

	# Memory Buffer
	$def[1]	.= rrd::area("mem_buffer", "#FCFFF5", "Memory Buffer");

	$def[1] .= "GPRINT:mem_buffer:LAST:\"%3.2lf %sB LAST \" ";
        $def[1] .= "GPRINT:mem_buffer:MAX:\"%3.2lf %sB MAX \" ";
        $def[1] .= "GPRINT:mem_buffer" . ':AVERAGE:"%3.2lf %sB AVERAGE \j" ';

	# Memory Total
	$def[1] .= rrd::line1("mem_total", "#000000", "Memory Total");

	$def[1] .= "GPRINT:mem_total:LAST:\"%3.2lf %sB LAST \" ";
        $def[1] .= "GPRINT:mem_total:MAX:\"%3.2lf %sB MAX \" ";
        $def[1] .= "GPRINT:mem_total" . ':AVERAGE:"%3.2lf %sB AVERAGE \j" ';

	# Second graph
	$opt[2] = "--vertical-label \"Bytes\" -l0 --base=1024 --title \"Memory Consumption Stratification for $hostname\" ";
	
	$def[2]	 = "DEF:mem_consumed_total=$RRDFILE[1]:$DS[2]:AVERAGE " ;
	$def[2] .= "DEF:mem_cache=$RRDFILE[1]:$DS[4]:AVERAGE " ;
	$def[2] .= "DEF:mem_buffer=$RRDFILE[1]:$DS[3]:AVERAGE " ;
	$def[2] .= "DEF:mem_high=$RRDFILE[1]:$DS[5]:AVERAGE " ;
	$def[2] .= "DEF:mem_low=$RRDFILE[1]:$DS[6]:AVERAGE " ;
	$def[2] .= "DEF:mem_unevictable=$RRDFILE[1]:$DS[9]:AVERAGE " ;
	$def[2] .= "DEF:mem_mlocked=$RRDFILE[1]:$DS[10]:AVERAGE " ;
	$def[2] .= "DEF:mem_slab=$RRDFILE[1]:$DS[11]:AVERAGE " ;
	$def[2] .= "DEF:mem_kernel=$RRDFILE[1]:$DS[12]:AVERAGE " ;
# Page Tables
	$def[2] .= "DEF:mem_yp=$RRDFILE[1]:$DS[13]:AVERAGE " ;
	$def[2] .= "DEF:mem_mapped=$RRDFILE[1]:$DS[14]:AVERAGE " ;

	$def[2] .= rrd::cdef("mem_fast_reclaim", "mem_low,mem_cache,+,mem_buffer,+");
	$def[2] .= rrd::area("mem_fast_reclaim", "#00FF00", "Fast Reclaimable Memory");
	$def[2] .= "GPRINT:mem_fast_reclaim:LAST:\"%3.2lf %sB LAST \" ";
	$def[2] .= "GPRINT:mem_fast_reclaim:MAX:\"%3.2lf %sB MAX \" ";
	$def[2] .= "GPRINT:mem_fast_reclaim" . ':AVERAGE:"%3.2lf %sB AVERAGE \j" ';

	$def[2] .= rrd::cdef("mem_slow_reclaim", "mem_high,mem_kernel,+,mem_mapped,+,mem_mlocked,+,mem_yp,+");
	$def[2] .= rrd::area("mem_slow_reclaim", "#FF0000", "Slow Reclaimable Memory");
	$def[2] .= "GPRINT:mem_slow_reclaim:LAST:\"%3.2lf %sB LAST \" ";
	$def[2] .= "GPRINT:mem_slow_reclaim:MAX:\"%3.2lf %sB MAX \" ";
	$def[2] .= "GPRINT:mem_slow_reclaim" . ':AVERAGE:"%3.2lf %sB AVERAGE \j" ';

	$def[2] .= rrd::cdef("mem_reclaim", "mem_consumed_total");
	$def[2] .= rrd::area("mem_reclaim", "#FFCC00", "Utilized Memory");
	$def[2] .= "GPRINT:mem_reclaim:LAST:\"%3.2lf %sB LAST \" ";
	$def[2] .= "GPRINT:mem_reclaim:MAX:\"%3.2lf %sB MAX \" ";
	$def[2] .= "GPRINT:mem_reclaim" . ':AVERAGE:"%3.2lf %sB AVERAGE \j" ';

	$def[2] .= rrd::cdef("mem_kernel_structs", "mem_slab,mem_kernel,+");
	$def[2] .= rrd::area("mem_kernel_structs", "#FF3399", "In-Kernel Memory Structures");
	$def[2] .= "GPRINT:mem_kernel_structs:LAST:\"%3.2lf %sB LAST \" ";
	$def[2] .= "GPRINT:mem_kernel_structs:MAX:\"%3.2lf %sB MAX \" ";
	$def[2] .= "GPRINT:mem_kernel_structs" . ':AVERAGE:"%3.2lf %sB AVERAGE \j" ';

	$def[2] .= rrd::cdef("mem_stuck", "mem_mlocked,mem_yp,+");
	$def[2] .= rrd::area("mem_stuck", "#7A0099", "Subsystem Memory");
	$def[2] .= "GPRINT:mem_stuck:LAST:\"%3.2lf %sB LAST \" ";
	$def[2] .= "GPRINT:mem_stuck:MAX:\"%3.2lf %sB MAX \" ";
	$def[2] .= "GPRINT:mem_stuck" . ':AVERAGE:"%3.2lf %sB AVERAGE \j" ';
?>
