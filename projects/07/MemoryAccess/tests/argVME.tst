
load arg.vm,
output-file arg.out,
compare-to arg.cmp,
output-list RAM[401]%D1.6.1 RAM[402]%D1.6.1;

set sp 256,
set local 300,
set argument 400,
set this 3000,
set that 3010,

repeat 4 {
  vmstep;
}

output;
