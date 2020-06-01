## This project shows solution for the next test [Task](TASK.md)

## Usage
* Install docker
* Run ```docker-composer up -d``` in the root directory of project
* Use localhost:8080 as host
* Follow [Documentation](DOC.md) to make requests 

## Known issues
* Write acceptance tests
* Psalm covering
* Optimizations like arguments resolving

## Some implementation details
* All events are saved to database. If the rabbit is broken, or the network is lagging, the messages will not be lost.
* In the statistics implementation considered that number of games (spins) is millions of raws. 
In this case, it is not appropriate to calculate statistics in runtime or use materialized views due to long queries or delays in data processing by m. views.
Long statistics requests in runtime calculation from **games** table can also be solved by grouping by months. It depends on requirements.