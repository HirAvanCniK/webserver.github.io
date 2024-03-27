import sys, base64

services = base64.b64decode(sys.argv[1].encode()+(b"="*4)).decode()

servs = {}

def reorder_json(data):
    running = []
    restartable = []
    exited = []
    for service, info in data.items():
        if info['sub'] == 'running':
            running.append((service, info))
        elif info['sub'] in ('start', 'auto-restart'):
            restartable.append((service, info))
        elif info['sub'] == 'exited':
            exited.append((service, info))
    return dict(running + restartable + exited)

for line in services.splitlines()[1:]:
    try:
        unit = line.split()[0]
        load = line.split()[1]
        active = line.split()[2]
        sub = line.split()[3]
        description = " ".join(line.split()[4:])
        servs[unit.split(".service")[0]] = {'load': load, 'active': active, 'sub': sub, 'description': description}
    except:
        continue

print(reorder_json(servs))

