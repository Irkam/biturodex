from django.contrib import admin
from biturodex.models import *


admin.site.register(User)
admin.site.register(Event)
admin.site.register(Establishment)
admin.site.register(EventType)
admin.site.register(EstablishmentType)
admin.site.register(Country)