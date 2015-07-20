
load local.vm,
output-file local.out,
compare-to local.cmp,
output-list RAM[300]%D1.6.1 RAM[302]%D1.6.1;

set sp 256,
set local 300,
set argument 400,
set this 3000,
set that 3010,

repeat 4 {
  vmstep;
}

output;
